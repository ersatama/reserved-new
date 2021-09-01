<?php

namespace App\Models;

use App\Domain\Contracts\IikoTableListContract;
use App\Domain\Contracts\IikoTablesContract;
use App\Domain\Contracts\OrganizationTableListContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IikoTableList extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   IikoTableListContract::FILLABLE;

    public function iikoTables()
    {
        return $this->belongsTo(IikoTables::class,IikoTablesContract::ID,IikoTableListContract::IIKO_TABLE_ID);
    }

    public function organizationTableList()
    {
        return $this->belongsTo(OrganizationTableList::class,IikoTableListContract::ORGANIZATION_TABLE_LIST_ID,OrganizationTableListContract::ID);
    }

}
