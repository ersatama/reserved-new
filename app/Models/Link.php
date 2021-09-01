<?php

namespace App\Models;

use App\Domain\Contracts\LinkContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    protected $fillable =   LinkContract::FILLABLE;
}
