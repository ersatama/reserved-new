<?php


namespace App\Domain\Repositories\User;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserContract;
use App\Models\User;
use Illuminate\Support\Str;

class UserRepositoryEloquent implements UserRepositoryInterface
{

    public function adminCreate(array $data)
    {
        $data[MainContract::API_TOKEN]  =   Str::random(60);
        return User::create($data);
    }

    public function create(array $data)
    {
        return  User::create([
            UserContract::USER_ID   =>  array_key_exists(UserContract::USER_ID,$data)?$data[UserContract::USER_ID]:null,
            UserContract::NAME      =>  $data[UserContract::NAME],
            UserContract::PHONE     =>  $data[UserContract::PHONE],
            UserContract::CODE      =>  rand(100000,999999),
            UserContract::PASSWORD  =>  $data[UserContract::PASSWORD],
            UserContract::API_TOKEN =>  Str::random(60)
        ]);
    }

    public function update($id, $input)
    {
        User::where(UserContract::ID,$id)->update($input);
        return User::where(UserContract::ID,$id)->first();
    }

    public function updatePhoneVerifiedAt() {
        $user   =   backpack_user();
        $user->phone_verified_at    =   date('Y-m-d G:i:s');
        return $user->save();
    }

    public function getById($id)
    {
        return User::where(UserContract::ID,$id)->first();
    }

    public function getByPhone($phone)
    {
        return User::where(UserContract::PHONE,$phone)->first();
    }

    public function getByPhoneAndPassword($phone)
    {
        return User::where(UserContract::PHONE,$phone)->first();
    }

    public function getByApiToken(string $token)
    {
        return User::where(UserContract::API_TOKEN,$token)->first();
    }

    public function smsVerify($phone,$code)
    {
        $user   =   User::where(MainContract::PHONE,$phone)->first();
        if ($user && ($user->code === $code)) {
            $user->phone_verified_at    =   date('Y-m-d H:i:s');
            $user->save();
            return $user;
        }
        return false;
    }

    public function smsResend($phone)
    {
        $user   =   User::where(MainContract::PHONE,$phone)->first();
        if ($user) {
            $user->{MainContract::CODE} =   rand(100000,999999);
            $user->save();
            return $user;
        }
        return false;
    }
}
