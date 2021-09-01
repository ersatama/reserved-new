<?php


namespace App\Services\Payment;

use App\Domain\Contracts\BookingContract;
use App\Domain\Contracts\MainContract;
use App\Domain\Repositories\Payment\PaymentRepositoryInterface;
use App\Domain\Contracts\PaymentContract;
use App\Helpers\Curl\Curl;
use App\Helpers\Xml\Xml;
use App\Models\Card;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $paymentRepository;
    protected $curl;
    protected $xml;

    const ID    =   538109;
    const KEY   =   'UVwuMp4af1xBXYCe';

    const SITE  =   'https://reserved-app.kz';
    const PHONE =   '+77021366697';
    const EMAIL =   'antechnology@bk.ru';

    const PKEY  =   'y3rB2e9V8XGcTlgO';
    const INIT  =   'init_payment.php';

    const STATUS    =   'get_status.php';
    const MAIN_URL  =   'https://api.paybox.money/init_payment.php';
    const REVOKE_URL    =   'https://api.paybox.money/revoke.php';

    const PAY_URL       =   'https://api.paybox.money/v1/merchant/'.self::STATUS;

    const CARD_ADD      =   'https://api.paybox.money/v1/merchant/'.self::ID.'/cardstorage/add';
    const CARD_LIST     =   'https://api.paybox.money/v1/merchant/'.self::ID.'/cardstorage/list';
    const CARD_DELETE   =   'https://api.paybox.money/v1/merchant/'.self::ID.'/cardstorage/remove';
    const CARD_PAYMENT  =   'https://api.paybox.money/v1/merchant/'.self::ID.'/card/init';
    const CARD_PAY      =   'https://api.paybox.money/v1/merchant/'.self::ID.'/card/pay';

    const CARD_RESULT   =   'https://reserved-app.kz/api/payment/card/result';
    const CARD_SUCCESS  =   'https://reserved-app.kz/profile/payments';
    const CARD_FAILURE  =   'https://reserved-app.kz/profile/payments';

    const CARD_POST =   'https://reserved-app.kz/api/card/post';
    const CARD_BACK =   'https://reserved-app.kz/profile/payments';

    const CARD_ADD_POST =   'https://reserved-app.kz/api/card/post/booking/';
    const CARD_ADD_BACK =   'https://reserved-app.kz/form/';

    const CURRENCY  =   'KZT';
    const CHECK_URL =   'https://reserved-app.kz/api/payment/check';
    const POST_URL  =   'https://reserved-app.kz/api/payment/post';
    const STATE_URL =   'https://reserved-app.kz/state';
    const LIFETIME  =   86400;
    const LANGUAGE  =   'ru';

    const REDIRECT_URL  =   'https://reserved-app.kz/payment/success';
    const RESULT_URL    =   'https://reserved-app.kz/api/payment/result';
    const SUCCESS_URL   =   'https://reserved-app.kz/profile/history';
    const FAILURE_URL   =   'https://reserved-app.kz/profile/history';
    const RETURN_URL    =   'https://reserved-app.kz/return';
    const PAYMENT_ROUTE =   'frame';



    const PAYMENT_SYSTEM    =   'EPAYWEBKZT';

    const RECURRING_LIFETIME    =   156;

    public function __construct(PaymentRepositoryInterface $paymentRepository, Curl $curl, Xml $xml) {
        $this->paymentRepository    =   $paymentRepository;
        $this->curl =   $curl;
        $this->xml  =   $xml;
    }

    public function revoke(Booking $booking)
    {
        $revoke =   $this->curl->post(self::REVOKE_URL,$this->signatureCard([
            MainContract::PG_MERCHANT_ID =>  self::ID,
            MainContract::PG_PAYMENT_ID  =>  $booking->{MainContract::PAYMENT_ID},
            MainContract::PG_REFUND_AMOUNT   =>  $booking->{MainContract::PRICE},//pg_refund_amount
            MainContract::PG_SALT        =>  rand(100000,999999),
        ],MainContract::REVOKE.'.php'));
        Log::info('remove',[$revoke]);
    }

    public static function paySignature($paymentId):array
    {
        if ($paymentId) {
            return self::signatureCard([
                PaymentContract::PG_MERCHANT_ID =>  self::ID,
                PaymentContract::PG_PAYMENT_ID  =>  $paymentId,
                PaymentContract::PG_SALT        =>  rand(100000,999999),
            ],MainContract::PAY);
        }
        return [];
    }

    public function create(Booking $booking, $card = true)
    {
        if ($card) {
            if ($payment = $this->paymentCard($booking)) {
                $booking->{MainContract::PAYMENT_URL}   =   self::CARD_PAY;
                $booking->{MainContract::PAYMENT_ID}    =   $payment[MainContract::PG_PAYMENT_ID];
                $booking->save();
                return $booking;
            }
            $booking->{MainContract::STATUS}    =   MainContract::OFF;
            $booking->save();
        }
        return false;
    }

    public function paymentCard(Booking $booking)
    {
        $payment    =   $this->curl->post(self::CARD_PAYMENT,$this->signatureCard([
            PaymentContract::PG_MERCHANT_ID =>  self::ID,
            PaymentContract::PG_AMOUNT      =>  $booking->{BookingContract::PRICE},
            PaymentContract::PG_ORDER_ID    =>  $booking->{BookingContract::ID},
            PaymentContract::PG_USER_ID     =>  $booking->{BookingContract::USER_ID},
            PaymentContract::PG_CARD_ID     =>  $booking->{BookingContract::CARD_ID},
            PaymentContract::PG_DESCRIPTION =>  'Бронирование столика №'.$booking->{BookingContract::ORGANIZATION_TABLE_LIST_ID},
            PaymentContract::PG_SALT        =>  rand(100000,999999),
            PaymentContract::PG_RESULT_URL  =>  self::CARD_RESULT,
            PaymentContract::PG_SUCCESS_URL =>  self::SUCCESS_URL,
            PaymentContract::PG_FAILURE_URL =>  self::FAILURE_URL
        ],MainContract::INIT));

        $xml    =   simplexml_load_string($payment);
        if ($xml && property_exists($xml,MainContract::PG_PAYMENT_ID)) {
            return json_decode(json_encode($xml),true);
        }

        return false;
    }

    public function cardDelete(Card $card)
    {
        $this->curl->post(self::CARD_DELETE,$this->signatureCard([
            MainContract::PG_MERCHANT_ID =>  self::ID,
            MainContract::PG_USER_ID     =>  $card->{MainContract::USER_ID},
            MainContract::PG_CARD_ID     =>  $card->{MainContract::CARD_ID},
            MainContract::PG_SALT        =>  rand(100000,999999),
        ],MainContract::REMOVE));
    }

    public function url($id, $price, $description, $userId, $cardId): string
    {
        return self::MAIN_URL.'?'.http_build_query($this->params($id, $price, $description, $userId, $cardId));
    }

    public function urlAdmin($id, $price, $description, $phone)
    {
        return $this->xml->enc($this->xml->loadFromString($this->curl->post(self::MAIN_URL,$this->signature([
            MainContract::PG_ORDER_ID    =>  $id,
            MainContract::PG_MERCHANT_ID =>  self::ID,
            MainContract::PG_AMOUNT      =>  $price,
            MainContract::PG_DESCRIPTION =>  $description,
            MainContract::PG_SALT        =>  rand(100000,999999),
            MainContract::PG_RESULT_URL  =>  self::RESULT_URL,
            MainContract::PG_REQUEST_METHOD  =>  MainContract::POST,
            MainContract::PG_SUCCESS_URL =>  self::SUCCESS_URL,
            MainContract::PG_SUCCESS_URL_METHOD  => MainContract::GET,
            MainContract::PG_FAILURE_URL =>  self::FAILURE_URL,
            MainContract::PG_FAILURE_URL_METHOD  => MainContract::GET,
            MainContract::PG_REDIRECT_URL    =>  self::REDIRECT_URL.'?id='.$id,
            MainContract::PG_USER_PHONE  =>  $phone
        ]))));
    }

    public function cardAddBooking($userId, $bookingId)
    {
        $arr    =   [
            MainContract::PG_MERCHANT_ID    =>  self::ID,
            MainContract::PG_USER_ID        =>  $userId,
            MainContract::PG_SALT           =>  rand(100000,99999),
            MainContract::PG_POST_LINK      =>  self::CARD_ADD_POST.$bookingId,
            MainContract::PG_BACK_LINK      =>  self::CARD_ADD_BACK.$bookingId,
        ];
        $xml    =   $this->xml->enc($this->xml->loadFromString($this->curl->post(self::CARD_ADD, $this->signatureCard($arr,MainContract::ADD))));
        if ($xml && array_key_exists(MainContract::PG_REDIRECT_URL,$xml)) {
            return $xml[MainContract::PG_REDIRECT_URL];
        }
        return $this->cardAddBooking($userId, $bookingId);
    }

    public function cardAdd($userId)
    {
        $arr    =   [
            MainContract::PG_MERCHANT_ID    =>  self::ID,
            MainContract::PG_USER_ID        =>  $userId,
            MainContract::PG_SALT           =>  rand(100000,99999),
            MainContract::PG_POST_LINK      =>  self::CARD_POST,
            MainContract::PG_BACK_LINK      =>  self::CARD_BACK,
        ];
        $xml    =   $this->xml->enc($this->xml->loadFromString($this->curl->post(self::CARD_ADD, $this->signatureCard($arr,MainContract::ADD))));
        if ($xml && array_key_exists(MainContract::PG_REDIRECT_URL,$xml)) {
            return $xml[MainContract::PG_REDIRECT_URL];
        }
        return $this->cardAdd($userId);
    }

    public static function signatureCard($request, $type)
    {
        ksort($request);
        array_unshift($request, $type);
        array_push($request, self::KEY);
        $request[MainContract::PG_SIG] = md5(implode(';', $request));
        unset($request[0], $request[1]);
        return $request;
    }

    public function signature($request) {
        $requestForSignature    =   $request;
        $requestForSignature = $this->makeFlatParamsArray($requestForSignature);
        ksort($requestForSignature);
        array_unshift($requestForSignature, self::INIT);
        array_push($requestForSignature, self::KEY);
        $request[PaymentContract::PG_SIG] = md5(implode(';', $requestForSignature));
        return $request;
    }

    public function params($id, $price, $description, $userId, $cardId) {
        return $this->signature([
            PaymentContract::PG_AMOUNT  =>  $price,
            PaymentContract::PG_SALT    =>  rand(100000,99999),
            PaymentContract::PG_USER_IP =>  $_SERVER[PaymentContract::REMOTE_ADDR],
            PaymentContract::PG_USER_ID =>  $userId,
            PaymentContract::PG_CARD_ID =>  $cardId,
            PaymentContract::PG_ORDER_ID    =>  $id,
            PaymentContract::PG_MERCHANT_ID =>  self::ID,
            PaymentContract::PG_DESCRIPTION =>  'Бронирование в '.$description,
            //PaymentContract::PG_CURRENCY    =>  self::CURRENCY,
            //PaymentContract::PG_CHECK_URL   =>  self::CHECK_URL,
            PaymentContract::PG_RESULT_URL  =>  self::RESULT_URL,
            PaymentContract::PG_SUCCESS_URL =>  self::SUCCESS_URL,
            PaymentContract::PG_FAILURE_URL =>  self::FAILURE_URL,
            //PaymentContract::PG_STATE_URL   =>  self::STATE_URL,
            //PaymentContract::PG_SITE_URL    =>  self::RETURN_URL.'/'.$id,
            //PaymentContract::PG_LIFETIME    =>  self::LIFETIME,
            PaymentContract::PG_USER_PHONE  =>  self::PHONE,
            PaymentContract::PG_LANGUAGE    =>  self::LANGUAGE,

            //PaymentContract::PG_RECURRING_START =>  1,
            PaymentContract::PG_TESTING_MODE    =>  1,
            //PaymentContract::PG_PAYMENT_ROUTE   =>  self::PAYMENT_ROUTE,
            //PaymentContract::PG_REQUEST_METHOD  =>  PaymentContract::POST,
            //PaymentContract::PG_PAYMENT_SYSTEM  =>  self::PAYMENT_SYSTEM,

            PaymentContract::PG_SUCCESS_URL_METHOD  =>  PaymentContract::GET,
            PaymentContract::PG_FAILURE_URL_METHOD  =>  PaymentContract::GET,
            //PaymentContract::PG_STATE_URL_METHOD    =>  PaymentContract::GET,
            PaymentContract::PG_USER_CONTACT_EMAIL  =>  self::EMAIL,
            //PaymentContract::PG_POSTPONE_PAYMENT    =>  0,

            //PaymentContract::PG_RECURRING_LIFETIME  =>  self::RECURRING_LIFETIME,
//            PaymentContract::PG_RECEIPT_POSITIONS   =>  [
//                [
//                    PaymentContract::COUNT  =>  1,
//                    PaymentContract::NAME   =>  'название товара',
//                    PaymentContract::TAX_TYPE   =>  3,
//                    PaymentContract::PRICE  =>  0,
//                ]
//            ],
        ]);
    }



    public function makeFlatParamsArray($arrParams, $parent_name = '') {
        $arr    =   [];
        $i      =   0;
        foreach ($arrParams as $key => $val) {
            $name   =   $parent_name.$key.sprintf('%03d', ++$i);
            if (is_array($val)) {
                $arr    =   array_merge($arr, $this->makeFlatParamsArray($val, $name));
                continue;
            }
            $arr    +=  array($name =>  (string)$val);
        }
        return $arr;
    }

    public function result($data):void {
        if (array_key_exists(MainContract::PG_RESULT,$data)) {
            if ((int) $data[MainContract::PG_RESULT] === 1) {
                $this->paymentRepository->success($data[MainContract::PG_ORDER_ID]);
            } else {
                $this->paymentRepository->failure($data[MainContract::PG_ORDER_ID]);
            }
        }
    }
}
