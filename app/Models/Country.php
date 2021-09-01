<?php

namespace App\Models;

use App\Domain\Contracts\CityContract;
use App\Domain\Contracts\CountryContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   CountryContract::FILLABLE;

    public function city()
    {
        return $this->hasMany(City::class,CityContract::COUNTRY_ID,CountryContract::ID);
    }
}
