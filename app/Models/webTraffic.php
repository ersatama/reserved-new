<?php

namespace App\Models;

use App\Domain\Contracts\WebTrafficContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class webTraffic extends Model
{
    use HasFactory;
    protected $fillable =   WebTrafficContract::FILLABLE;
}
