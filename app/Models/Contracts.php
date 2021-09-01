<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Contracts\ContractContract;

class Contracts extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   ContractContract::FILLABLE;

    public function setJsonAttribute($value) {
        $this->attributes[ContractContract::JSON]   =   htmlspecialchars($value);
    }
}
