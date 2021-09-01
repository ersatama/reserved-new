<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable =   UserContract::FILLABLE;
    protected $hidden   =   UserContract::HIDDEN;
    protected $casts    =   UserContract::CASTS;

    public function setPasswordAttribute($value)
    {
        $this->attributes[MainContract::PASSWORD] = bcrypt($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes[MainContract::NAME] = ucfirst(strtolower($value));
    }

    public function getStatusAttribute($value): string
    {
        return MainContract::TRANSLATE[$value];
    }

    public function getCreatedAtAttribute($value)
    {
        return MainContract::dateCheck($value);
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return MainContract::verifiedCheck($value);
    }

    public function getPhoneVerifiedAtAttribute($value)
    {
        return MainContract::verifiedCheck($value);
    }

    public function getRoleAttribute($value)
    {
        return MainContract::getCheck($value);
    }

    public function getBlockedAttribute($value)
    {
        return MainContract::getCheck($value);
    }
}
