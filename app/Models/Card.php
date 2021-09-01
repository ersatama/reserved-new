<?php

namespace App\Models;

use App\Domain\Contracts\CardContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    protected $fillable =   CardContract::FILLABLE;
}
