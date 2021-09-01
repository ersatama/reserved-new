<?php


namespace App\Helpers\Iiko;

use App\Domain\Contracts\BookingContract;
use App\Domain\Contracts\IikoContract;
use App\Domain\Contracts\IikoTableListContract;
use App\Domain\Contracts\IikoTablesContract;
use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserContract;
use App\Helpers\Curl\Curl;

use App\Services\User\UserService;
use App\Services\Organization\OrganizationService;
use App\Services\Iiko\IikoService;
use App\Services\Iiko\IikoTables\IikoTablesService;
use App\Services\Iiko\IikoTableList\IikoTableListService;
use App\Services\Booking\BookingService;

use App\Models\Iiko as IikoModel;

class Iiko
{
    const URL               =   'https://iiko.biz:9900/api/0/auth/access_token';
    const URL_ORDER         =   'https://iiko.biz:9900/api/0/orders/add';
    const URL_ORGANIZATION  =   'https://iiko.biz:9900/api/0/organization/list';
    const URL_SECTIONS      =   'https://iiko.biz:9900/api/0/rmsSettings/getRestaurantSections';

    const AUTH              =   'https://api-ru.iiko.services/api/1/access_token';
    const ORGANIZATIONS     =   'https://api-ru.iiko.services/api/1/organizations';
    const TERMINALS         =   'https://api-ru.iiko.services/api/1/terminal_groups';
    const SECTIONS          =   'https://api-ru.iiko.services/api/1/reserve/available_restaurant_sections';
    const RESERVE           =   'https://api-ru.iiko.services/api/1/reserve/create';

    public $token;

    protected $curl;
    protected $userService;
    protected $organizationService;
    protected $iikoService;
    protected $iikoTablesService;
    protected $iikoTableListService;
    protected $bookingService;

    public function __construct(Curl $curl ,UserService $userService, OrganizationService $organizationService,IikoService $iikoService, IikoTablesService $iikoTablesService, IikoTableListService $iikoTableListService, BookingService $bookingService)
    {
        $this->curl =   $curl;
        $this->userService  =   $userService;
        $this->organizationService  =   $organizationService;
        $this->iikoService  =   $iikoService;
        $this->iikoTablesService    =   $iikoTablesService;
        $this->iikoTableListService =   $iikoTableListService;
        $this->bookingService   =   $bookingService;
    }

    public function booking($id)
    {
        if ($booking    =   $this->bookingService->getById($id)) {
            $reserve    =   json_decode($this->postTokenReserve($this->getSessionToken($booking->{MainContract::ORGANIZATION}->{MainContract::API_KEY}),$booking),true);
        }
    }

    public function postTokenReserve($token,$booking)
    {

        $iiko   =   $this->iikoService->getByOrganizationId($booking->{MainContract::ORGANIZATION_ID});
        $table  =   $this->iikoTableListService->getByOrganizationTableListId($booking->{MainContract::ORGANIZATION_TABLE_LIST_ID});

        if (sizeof($iiko) > 0 && $table) {

            $organizations  =   $this->getOrganizationList($token,$iiko->{MainContract::IIKO_ORGANIZATION_ID});
            $terminals      =   $this->getTerminalList($token, $organizations);
            $user           =   $this->userService->getById($booking->{MainContract::USER_ID});

            return $this->curl->postTokenReserve(self::RESERVE,$token,[
                'organizationId'    =>  $organizations[0],
                'terminalGroupId'   =>  $terminals[0],
                'customer'          =>  [
                    'id'    =>  $user->{UserContract::ID},
                    'name'  =>  $user->{UserContract::NAME},
                ],
                'phone'             =>  '+'.$user->{UserContract::PHONE},
                'guestsCount'       =>  ($booking->organizationTables->limit >= 1?$booking->organizationTables->limit:2),
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
                    $table->{IikoTableListContract::KEY}
                ],
                'shouldRemind'  =>  true,
                'estimatedStartTime'    =>  date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($booking->created_at)).' '.$booking->time)).'.000'
            ]);
        }
    }

    /*
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
     */

    public function getOrganizations($id,$secret):array
    {
        if ($organizations  =   $this->curl->get(self::URL_ORGANIZATION.'?access_token='.$this->getToken($id,$secret))) {
            return json_decode($organizations,true)[0];
        }
        return [];
    }

    public function getRooms(IikoModel $iiko)
    {
        if ($iiko->{IikoContract::IIKO_ORGANIZATION_ID}) {
            $token  =   $this->getSessionToken($iiko->{IikoContract::API_KEY});
            $sections   =   $this->getSectionList(
                $token,
                $this->getTerminalList(
                    $token,
                    $this->getOrganizationList($token,$iiko->{IikoContract::IIKO_ORGANIZATION_ID})
                )
            );
            foreach ($sections as $key=>$value) {
                $section    =   $this->iikoTablesService->create([
                    IikoTablesContract::IIKO_MAIN_ID    =>  $iiko->{IikoContract::ID},
                    IikoTablesContract::KEY =>  $key,
                    IikoTablesContract::NAME    =>  $value[IikoTablesContract::NAME]
                ]);
                foreach ($value['tables'] as $table) {
                    $this->iikoTableListService->create([
                        IikoTableListContract::IIKO_MAIN_ID =>  $iiko->{IikoContract::ID},
                        IikoTableListContract::IIKO_TABLE_ID    =>  $section->{IikoTablesContract::ID},
                        IikoTableListContract::KEY  =>  $table[IikoTableListContract::ID],
                        IikoTableListContract::TITLE    =>  $table[IikoTableListContract::NAME],
                        IikoTableListContract::LIMIT    =>  $table[IikoTableListContract::SEATING_CAPACITY],
                    ]);
                }
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

    public function getToken($id, $secret):string
    {
        if (!$this->token) {
            $this->token    =   str_replace('"', '', $this->curl->get(self::URL.'?user_id='.$id.'&user_secret='.$secret));
        }
        return $this->token;
    }

}
