<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Contracts\PrivacyContract;

class Privacy extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable =   PrivacyContract::FILLABLE;

    public function setJsonAttribute($value) {
        $this->attributes[PrivacyContract::JSON]   =   htmlspecialchars($value);
    }
}
