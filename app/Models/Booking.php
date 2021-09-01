<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Contracts\BookingContract;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable =   BookingContract::FILLABLE;


    public function getTimeAttribute($value): string
    {
        $date   =   explode(' ',$this->{MainContract::CREATED_AT});
        $time   =   new \DateTime($date[0].' '.$value, new \DateTimeZone(MainContract::UTC));
        $time->setTimezone(new \DateTimeZone($this->organization->timezone));
        return $time->format('H:i');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, MainContract::ORGANIZATION_ID,MainContract::ID);
    }

    public function organizationTables(): HasOne
    {
        return $this->hasOne(OrganizationTableList::class,MainContract::ID,MainContract::ORGANIZATION_TABLE_LIST_ID);
    }

}
