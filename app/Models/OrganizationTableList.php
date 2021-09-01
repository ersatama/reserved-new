<?php

namespace App\Models;

use App\Domain\Contracts\OrganizationTableListContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Organization;

class OrganizationTableList extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable =   OrganizationTableListContract::FILLABLE;
    public function organization() {
        return $this->belongsTo(Organization::class);
    }

    public function organizationTable() {
        return $this->belongsTo(OrganizationTables::class);
    }
}
