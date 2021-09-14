<?php

namespace App\Models;

use App\Domain\Contracts\NewsSubscribeContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsSubscribe extends Model
{
    use HasFactory;

    protected $fillable =   NewsSubscribeContract::FILLABLE;
}
