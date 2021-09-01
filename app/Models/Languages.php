<?php

namespace App\Models;

use App\Domain\Contracts\LanguagesContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   LanguagesContract::FILLABLE;
}
