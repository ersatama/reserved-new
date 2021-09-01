<?php

namespace App\Models;

use App\Domain\Contracts\IikoContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iiko extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   IikoContract::FILLABLE;

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function setIikoIdAttribute($value)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }
}
