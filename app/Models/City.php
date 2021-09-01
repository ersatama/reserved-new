<?php

namespace App\Models;

use App\Domain\Contracts\CityContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;

class City extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable =   CityContract::FILLABLE;

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
