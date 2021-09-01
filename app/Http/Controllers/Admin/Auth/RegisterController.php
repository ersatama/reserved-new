<?php


namespace App\Http\Controllers\Admin\Auth;

use Backpack\CRUD\app\Http\Controllers\Auth\RegisterController as BackpackRegisterController;
use App\Domain\Contracts\UserContract;
use App\Services\User\UserService;
use App\Services\Sms\SmsService;
use Validator;

class RegisterController extends BackpackRegisterController
{
    protected $userService;
    protected $smsService;
    public function __construct(UserService $userService, SmsService $smsService)
    {
        parent::__construct();
        $this->userService  =   $userService;
        $this->smsService   =   $smsService;
    }

    protected function validator(array $data)
    {
        $user_model_fqn =   config('backpack.base.user_model_fqn');
        $user           =   new $user_model_fqn();
        $users_table    =   $user->getTable();

        return Validator::make($data, [
            UserContract::NAME      =>  'required|min:2|max:255',
            UserContract::PHONE     =>  'required|max:255|unique:'.$users_table,
            UserContract::PASSWORD  =>  'required|min:8',
        ]);
    }

    protected function create(array $data)
    {
        $user           =   $this->userService->create($data);
        $this->smsService->sendCode($user->phone,$user->code);
        return $user;
    }
}
