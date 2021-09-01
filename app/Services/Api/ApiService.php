<?php


namespace App\Services\Api;

use App\Services\BaseService;
use App\Domain\Contracts\BookingContract;
use App\Domain\Contracts\OrganizationTablesContract;
use App\Domain\Repositories\User\UserRepositoryInterface;
use App\Domain\Repositories\Organization\OrganizationRepositoryInterface;
use App\Domain\Repositories\OrganizationTable\OrganizationTableRepositoryInterface;
use App\Domain\Repositories\OrganizationTableList\OrganizationTableListRepositoryInterface;
use App\Domain\Repositories\Booking\BookingRepositoryInterface;

use App\Helpers\Curl\Curl;

class ApiService extends BaseService
{
//    const USER_ID       =   'api25';
//    const USER_SECRET   =   'Qwerty00';
    const PATH              =   'https://iiko.biz:9900';
    const API               =   '/api/0';
    const URL               =   'https://iiko.biz:9900'.self::API.'/auth/access_token';
    const URL_ORDER         =   self::PATH.self::API.'/orders/add';
    const URL_ORGANIZATION  =   'https://iiko.biz:9900/api/0/organization/list';
    const URL_SECTIONS      =   self::PATH.self::API.'/rmsSettings/getRestaurantSections';

    const AUTH              =   'https://api-ru.iiko.services/api/1/access_token';
    const ORGANIZATIONS     =   'https://api-ru.iiko.services/api/1/organizations';
    const TERMINALS         =   'https://api-ru.iiko.services/api/1/terminal_groups';
    const SECTIONS          =   'https://api-ru.iiko.services/api/1/reserve/available_restaurant_sections';
    const RESERVE           =   'https://api-ru.iiko.services/api/1/reserve/create';

    public $token;
    protected $userRepository;
    protected $organizationRepository;
    protected $organizationTableRepository;
    protected $organizationTableListRepository;
    protected $bookingRepository;
    protected $curl;

    public function __construct(UserRepositoryInterface $userRepository, OrganizationRepositoryInterface $organizationRepository, OrganizationTableRepositoryInterface $organizationTableRepository, Curl $curl, OrganizationTableListRepositoryInterface $organizationTableListRepository, BookingRepositoryInterface $bookingRepository) {
        $this->userRepository               =   $userRepository;
        $this->organizationRepository       =   $organizationRepository;
        $this->organizationTableRepository  =   $organizationTableRepository;
        $this->organizationTableListRepository  =   $organizationTableListRepository;
        $this->bookingRepository            =   $bookingRepository;
        $this->curl                         =   $curl;
    }

    public function getOrganizationId(string $id,string $secret) {
        return $this->getOrganizations($this->getToken($id,$secret));
    }

    public function booking($id) {
        if ($booking    =   $this->bookingRepository->getById($id)) {
            $reserve    =   json_decode($this->postTokenReserve($this->getSessionToken($booking->organization->api_key),$booking),true);
            if (array_key_exists('reserveInfo',$reserve)) {
                $this->bookingRepository->updateIikoBookingId($id,$reserve['reserveInfo']['id']);
            }
        }
    }

    public function postTokenReserve($token,$booking) {

        $organizations  =   $this->getOrganizationList($token,$booking->organization->iiko_organization_id);
        $terminals      =   $this->getTerminalList($token,$organizations);
        $user           =   $this->userRepository->getById($booking->user_id);

        return $this->curl->postTokenReserve(self::RESERVE,$token,[
            'organizationId'    =>  $organizations[0],
            'terminalGroupId'   =>  $terminals[0],
            'customer'          =>  [
                'id'    =>  $booking->user_id,
                'name'  =>  $user->name,
            ],
            'phone'             =>  '+'.$user->phone,
            'guestsCount'       =>  ($booking->organizationTables->limit>1?$booking->organizationTables->limit:2) ,
            'durationInMinutes' =>  100,
            'order'     =>  [
                'items'     =>  [
                    [
                        'type'      =>  'Product',
                        'productId' =>  'ac18f6a7-059e-4deb-8d72-0bc12289544e',
                        'amount'    =>  1
                    ]
                ],
                'payments'  =>  [
                    [
                        'paymentTypeKind'       =>  'Card',
                        'sum'                   =>  $booking->organization->price,
                        'paymentTypeId'         =>  'e46b4e6c-10d5-a739-8fb1-b6674d1e65e7',
                        'isProcessedExternally' =>  true
                    ]
                ],
            ],
            'tableIds'  =>  [
                $booking->organizationTables->key
            ],
            'shouldRemind'  =>  true,
            'estimatedStartTime'    =>  date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($booking->created_at)).' '.$booking->time)).'.000'
        ]);

    }

    public function createOrder() {
        $url    =   self::URL_ORDER.'?access_token='.$this->token.'&request_timeout=15';
    }

    public function getRooms($data) {
        $token          =   $this->getSessionToken($data->api_key);
        $sections       =   $this->getSectionList(
            $token,
            $this->getTerminalList(
                $token,
                $this->getOrganizationList($token,$data->iiko_organization_id)
            )
        );
        foreach ($sections as $key=>$value) {
            $section    =   $this->organizationTableRepository->create($data->id,$key,$value['name']);
            foreach ($value['tables'] as &$table) {
                $this->organizationTableListRepository->create(
                    $data->id,
                    $section->id,
                    $table['id'],
                    $table['name'],
                    $table['seatingCapacity']
                );
            }
        }
    }

    public function getSectionList($token,$terminals):array {
        $arr    =   [];
        $sections   =   json_decode($this->curl->postToken(self::SECTIONS,$token,[
            "terminalGroupIds"  =>  $terminals,
            "returnSchema"      =>  false
        ],false),true);
        if (array_key_exists('restaurantSections',$sections)) {
            foreach ($sections['restaurantSections'] as &$section) {
                $arr[$section['id']]    =   [
                    'name'  =>  $section['name'],
                    'tables'    =>  []
                ];
                if (array_key_exists('tables',$section)) {
                    foreach ($section['tables'] as &$table) {
                        $arr[$section['id']]['tables'][]    =   $table;
                    }
                }
            }
        }
        return $arr;
    }

    public function getTerminalList($token, $organizations):array {
        $arr    =   [];
        $terminals  =   json_decode($this->curl->postToken(self::TERMINALS,$token,[
            "organizationIds"   =>  $organizations,
            "includeDisabled"   =>  true
        ],false),true);
        if (array_key_exists('terminalGroups',$terminals)) {
            foreach ($terminals['terminalGroups'] as &$value) {
                if (array_key_exists('items',$value)) {
                    foreach ($value['items'] as &$item) {
                        $arr[]  =   $item['id'];
                    }
                }
            }
        }
        return $arr;
    }

    public function getOrganizationList($token,$id):array {
        $arr            =   [];
        $organizations  =   json_decode($this->curl->postToken(self::ORGANIZATIONS,$token,[
            "organizationIds"   =>  [
                $id
            ],
            "returnAdditionalInfo"  =>  false,
            "includeDisabled"   =>  false
        ],false),true);
        if (array_key_exists('organizations',$organizations)) {
            foreach ($organizations['organizations'] as &$value) {
                $arr[]  =   $value['id'];
            }
        }
        return $arr;
    }

    public function getSessionToken($key) {
        $token  =   json_decode($this->curl->postToken(self::AUTH,'',[
            'apiLogin'  =>  $key
        ],false),true);
        if (array_key_exists('token',$token)) {
            return $token['token'];
        }
        return [];
    }

    public function getOrganizations(string $token)
    {
        if ($organizations  =   $this->curlGet(self::URL_ORGANIZATION.'?access_token='.$token)) {
            return json_decode($organizations,true)[0];
        }
        return [];
    }

    public function getToken($id,$secret)
    {
        if (!$this->token) {
            $this->token    =   str_replace('"', '', $this->curlGet(self::URL.'?user_id='.$id.'&user_secret='.$secret));
        }
        return $this->token;
    }

    public function curlGet(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
