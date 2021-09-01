<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\BookingContract;
use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserContract;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Services\User\UserService;
use App\Services\Organization\OrganizationService;
use App\Services\Sms\SmsService;
use App\Services\Booking\BookingService;
use App\Services\OrganizationTableList\OrganizationTableListService;

use App\Http\Resources\UserResource;
use App\Http\Resources\Booking\BookingResource;

use App\Jobs\BookingPayment;
use App\Jobs\UserPassword;
use App\Jobs\UserCode;

use App\Helpers\Time\Time;
use App\Helpers\Random\Random;

use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserGuestRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\UserPasswordRequest;
use App\Http\Requests\User\UserPasswordResetRequest;
use Illuminate\Validation\ValidationException;
use Pusher\Pusher;

class UserController extends Controller
{

    protected $userService;
    protected $smsService;
    protected $bookingService;
    protected $organizationService;
    protected $organizationTableListService;

    public function __construct(UserService $userService, OrganizationService $organizationService, SmsService $smsService, BookingService $bookingService, OrganizationTableListService $organizationTableListService)
    {
        $this->userService  =   $userService;
        $this->smsService   =   $smsService;
        $this->bookingService   =   $bookingService;
        $this->organizationService  =   $organizationService;
        $this->organizationTableListService =   $organizationTableListService;
    }

    public function guest(UserGuestRequest $userGuestRequest)
    {
        $data   =   $userGuestRequest->validated();
        $user   =   $this->userService->smsResend($data[MainContract::PHONE]);
        if (!$user) {
            $user   =   $this->userService->create($data);
            UserPassword::dispatch($user,$data[MainContract::PASSWORD]);
        }
        UserCode::dispatch($user);
        return $user;
    }

    public function authToken($token, Request $request)
    {
        $user   =   $this->userService->getByApiToken($token);
        if ($user) {
            $pusher =   new Pusher('e23697fdbb3e80ef3f02', '2ea1521a812e703e95df', '1241620');
            return $pusher->socket_auth($request->get('channel_name'), $request->get('socket_id'));
        }
        return response(['message'  =>  'Пользователь не найден'],404);
    }

    public function booking(Request $request)
    {
        $user   =   $this->userService->getByPhone($request->input(MainContract::PHONE));
        $password   =   rand(100000,999999);
        $status =   false;
        if (!$user) {
            $user   =   $this->userService->adminCreate([
                MainContract::USER_ID   =>  $request->input(MainContract::USER_ID),
                MainContract::NAME  =>  $request->input(MainContract::NAME),
                MainContract::PHONE =>  $request->input(MainContract::PHONE),
                MainContract::PHONE_VERIFIED_AT =>  date('Y-m-d H:i:s'),
                MainContract::PASSWORD  =>  $password
            ]);
            $status =   true;
        }

        $organization   =   $this->organizationService->getById($request->input(MainContract::ORGANIZATION_ID));
        $table          =   $this->organizationTableListService->getById($request->input(MainContract::ORGANIZATION_TABLE_ID));

        $price          =   $table->{MainContract::PRICE}>0?$table->{MainContract::PRICE}:$organization->{MainContract::PRICE};

        $booking    =   [
            MainContract::USER_ID    =>  $user->{MainContract::ID},
            MainContract::ORGANIZATION_ID    =>  $request->input(MainContract::ORGANIZATION_ID),
            MainContract::ORGANIZATION_TABLE_LIST_ID  =>  $request->input(MainContract::ORGANIZATION_TABLE_ID),
            MainContract::TIME   =>  Time::toLocal($request->input(MainContract::DATE).' '.$request->input(MainContract::TIME), $request->input(MainContract::TIMEZONE)),
            MainContract::DATE   =>  $request->input(MainContract::DATE),
            MainContract::PRICE  =>  $price
        ];

        if ($price < 1) {
            $booking[MainContract::STATUS]   =   MainContract::ON;
        } else {
            $booking[MainContract::STATUS]  =   MainContract::CHECKING;
        }

        $booking    =   $this->bookingService->create($booking);
        if ($price > 0) {
            BookingPayment::dispatch([
                MainContract::ID =>  $booking->id,
                MainContract::ORGANIZATION_ID    =>  $request->input(MainContract::ORGANIZATION_ID),
                MainContract::USER_ID   =>  $user->{MainContract::ID},
                MainContract::PRICE     =>  $price
            ]);
        }
        $booking->{MainContract::USER}  =   $user;

        if ($status) {
            UserPassword::dispatch($user,$password,$booking);
        }

        return new BookingResource($booking);
    }

    public function getByPhone($phone)
    {
        $user   =   $this->userService->getByPhone($phone);
        if ($user) {
            return new UserResource($user);
        }
        return response(['message'  =>  'Пользователь не найден'],404);
    }

    /**
     * @throws ValidationException
     */
    public function update($id, UserUpdateRequest $userUpdateRequest): UserResource
    {
        return new UserResource($this->userService->update($id,$userUpdateRequest->validated()));
    }

    /**
     * @throws ValidationException
     */
    public function resetPassword($id, UserPasswordResetRequest $userPasswordResetRequest)
    {
        $this->userService->update($id,[
            MainContract::PASSWORD  =>  Hash::make($userPasswordResetRequest->validated()[MainContract::PASSWORD])
        ]);
        return response(['message'  =>  'Ваш пароль успешно изменен'],200);
    }

    /**
     * @throws ValidationException
     */
    public function updatePassword($id, UserPasswordRequest $userPasswordRequest)
    {
        $data   =   $userPasswordRequest->validated();
        $user   =   $this->userService->getById($id);
        if (Hash::check($data[MainContract::OLD], $user->{MainContract::PASSWORD})) {
            if (strlen($data[MainContract::NEW]) >= 8) {
                $this->userService->update($id,[
                    MainContract::PASSWORD  =>  Hash::make($data[MainContract::NEW])
                ]);
                return response(['message'  =>  'Ваш пароль успешно изменен'],200);
            }
            return response(['message'  =>  'Пароль должен содержать минимум из 8 символов'],400);
        }
        return response(['message'  =>  'Не правильный пароль'],400);
    }

    public function getById($id)
    {
        $user   =   $this->userService->getById($id);
        if ($user) {
            return new UserResource($user);
        }
        return response(['message'  =>  'Пользователь не найден'],404);
    }

    public function smsVerify($phone,$code)
    {
        $user   =   $this->userService->smsVerify($phone,$code);
        if ($user) {
            return new UserResource($user);
        }
        return response(['message'  =>  'Не правильный код'],400);
    }

    public function smsResend($phone)
    {
        $user   =   $this->userService->smsResend($phone);
        if ($user) {
            $this->smsService->sendCode($user->{MainContract::PHONE},$user->{MainContract::CODE});
            return new UserResource($user);
        }
        return response(['message'  =>  'Телефон номер не зарегистрирован'],400);
    }

    public function token($token)
    {
        $user   =   $this->userService->getByApiToken($token);
        if ($user) {
            return new UserResource($user);
        }
        return response(['message'  =>  'token expired'],404);
    }

    public function login(string $phone, string $password)
    {
        $user   =   $this->userService->getByPhoneAndPassword($phone);
        if ($user && Hash::check($password,$user->password)) {
            return new UserResource($user);
        }
        return response(['message'  =>  'incorrect phone or password'],401);
    }

    /**
     * @throws ValidationException
     */
    public function register(UserCreateRequest $request): UserResource
    {
        $user   =   $this->userService->create($request->validated());
        $this->smsService->sendCode($user->phone,$user->code);
        return new UserResource($user);
    }

}
