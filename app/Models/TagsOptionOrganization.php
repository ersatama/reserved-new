<?php

namespace App\Models;

use App\Domain\Contracts\TagsOptionOrganizationContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagsOptionOrganization extends Model
{
    use HasFactory;
    protected $fillable =   TagsOptionOrganizationContract::FILLABLE;
}
