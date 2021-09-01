<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\OrganizationTablesContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationTables extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable =   OrganizationTablesContract::FILLABLE;

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function organizationTables(): HasMany
    {
        return $this->hasMany(OrganizationTableList::class, MainContract::ORGANIZATION_TABLE_ID, MainContract::ID)->where(MainContract::STATUS,'!=', MainContract::DISABLED);
    }
}
