<?php


namespace App\Helpers\Sms;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserContract;
use App\Models\User;
use App\Helpers\Curl\Curl;
use App\Helpers\Whatsapp\Whatsapp;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Log;

class Sms
{
    protected $link     =   'https://reserved-app.kz';
    protected $login    =   'An-technology';
    protected $password =   'ygABGazD55XJ4NcesmBo';
    protected $url      =   'https://smsc.kz/sys/send.php';
    protected $curl;
    protected $userService;
    protected $whatsapp;
    public function __construct(Curl $curl, UserService $userService, Whatsapp $whatsapp)
    {
        $this->curl =   $curl;
        $this->userService  =   $userService;
        $this->whatsapp =   $whatsapp;
    }

    public function booking($booking)
    {
        $user   =   $this->userService->getById($booking->{MainContract::USER_ID});
        $this->whatsapp->send([
            MainContract::PHONE =>  $user->{MainContract::PHONE},
            MainContract::BODY  =>  'Здравствуйте '.$user->{MainContract::NAME}.', вам забронирован столик в '.$booking->organization->{MainContract::TITLE}.' на '.$booking->{MainContract::TIME}.'. c уважением reserved-app.kz'
        ]);

        /*$this->curl->get($this->url.'?'.$this->parameters([
            'phones'    =>  $user->{MainContract::PHONE},
            'mes'       =>  'Здравствуйте '.$user->{MainContract::NAME}.', вам забронирован столик в '.$booking->organization->{MainContract::TITLE}.' на '.$booking->{MainContract::TIME}.'. c уважением reserved-app.kz'
        ]));*/
    }

    public function code(User $user):void
    {
        $this->whatsapp->send([
            MainContract::PHONE =>  $user->{MainContract::PHONE},
            MainContract::BODY  =>  'Reserved-app Ваш код: '.$user->{MainContract::CODE}
        ]);
        /*$this->curl->get($this->url.'?'.$this->parameters([
            'phones'    =>  $user->{MainContract::PHONE},
            'mes'       =>  'Reserved-app Ваш код: '.$user->{MainContract::CODE}
        ]));*/
    }

    public function password(User $user, string $password, $booking =   null):void
    {
        if (!$booking) {
            $this->whatsapp->send([
                MainContract::PHONE =>  $user->{MainContract::PHONE},
                MainContract::BODY  =>  'Reserved-app Ваш логин: +'.$user->{MainContract::PHONE}.',ваш пароль: '.$password.' для входа, никому не сообщайте. reserved-app.kz'
            ]);
            /*$this->curl->get($this->url.'?'.$this->parameters([
                    'phones'    =>  $user->{MainContract::PHONE},
                    'mes'       =>  'Reserved-app ваш пароль: '.$password.' для входа, никому не сообщайте'
                ]));*/
        } else {
            $this->whatsapp->send([
                MainContract::PHONE =>  $user->{MainContract::PHONE},
                MainContract::BODY  =>  'Здравствуйте '.$user->{MainContract::NAME}.', вам забронирован столик в '.$booking->organization->{MainContract::TITLE}.' на '.$booking->{MainContract::TIME}.'. Ваш пароль: '.$password.' для входа на сайт, c уважением reserved-app.kz'
            ]);
           /* $this->curl->get($this->url.'?'.$this->parameters([
                    'phones'    =>  $user->{MainContract::PHONE},
                    'mes'       =>  'Здравствуйте '.$user->{MainContract::NAME}.', вам забронирован столик в '.$booking->organization->{MainContract::TITLE}.' на '.$booking->{MainContract::TIME}.'. Ваш пароль: '.$password.' для входа на сайт, c уважением reserved-app'
                ]));*/
        }
    }

    public function parameters(array $data): string
    {
        $arr    =   array_merge([
            'login' =>  $this->login,
            'psw'   =>  $this->password,
        ],$data);
        return http_build_query($arr);
    }

}
