<?php

namespace App\Models;

use App\Domain\Contracts\PaymentContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable =   PaymentContract::FILLABLE;
}
