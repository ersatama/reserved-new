<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\OrganizationContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class Organization extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   OrganizationContract::FILLABLE;

    private $start_monday;
    private $end_monday;
    private $start_tuesday;
    private $end_tuesday;
    private $start_wednesday;
    private $end_wednesday;
    private $start_thursday;
    private $end_thursday;
    private $start_friday;
    private $end_friday;
    private $start_saturday;
    private $end_saturday;
    private $start_sunday;
    private $end_sunday;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function setStartMondayAttribute($value)
    {
        $this->attributes[MainContract::START_MONDAY] =   $value.':00';
    }

    public function setEndMondayAttribute($value)
    {
        $this->attributes[MainContract::END_MONDAY] =   $value.':00';
    }

    public function setStartTuesdayAttribute($value)
    {
        $this->attributes[MainContract::START_TUESDAY] =   $value.':00';
    }

    public function setEndTuesdayAttribute($value)
    {
        $this->attributes[MainContract::END_TUESDAY] =   $value.':00';
    }

    public function setStartWednesdayAttribute($value)
    {
        $this->attributes[MainContract::START_WEDNESDAY] =   $value.':00';
    }

    public function setEndWednesdayAttribute($value)
    {
        $this->attributes[MainContract::END_WEDNESDAY] =   $value.':00';
    }

    public function setStartThursdayAttribute($value)
    {
        $this->attributes[MainContract::START_THURSDAY] =   $value.':00';
    }

    public function setEndThursdayAttribute($value)
    {
        $this->attributes[MainContract::END_THURSDAY] =   $value.':00';
    }

    public function setStartFridayAttribute($value)
    {
        $this->attributes[MainContract::START_FRIDAY] =   $value.':00';
    }

    public function setEndFridayAttribute($value)
    {
        $this->attributes[MainContract::END_FRIDAY] =   $value.':00';
    }

    public function setStartSaturdayAttribute($value)
    {
        $this->attributes[MainContract::START_SATURDAY] =   $value.':00';
    }

    public function setEndSaturdayAttribute($value)
    {
        $this->attributes[MainContract::END_SATURDAY] =   $value.':00';
    }

    public function setStartSundayAttribute($value)
    {
        $this->attributes[MainContract::START_SUNDAY] =   $value.':00';
    }

    public function setEndSundayAttribute($value)
    {
        $this->attributes[MainContract::END_SUNDAY] =   $value.':00';
    }

    public function getStartMondayAttribute($value): string
    {
        $split  =   explode(':',$value);
        return $split[0].':'.$split[1];
    }

    public function getEndMondayAttribute($value): string
    {
        $split  =   explode(':',$value);
        return $split[0].':'.$split[1];
    }

    public function getStartTuesdayAttribute($value): string
    {
        $split  =   explode(':',$value);
        return $split[0].':'.$split[1];
    }

    public function getEndTuesdayAttribute($value): string
    {
        $split  =   explode(':',$value);
        return $split[0].':'.$split[1];
    }

    public function getStartWednesdayAttribute($value): string
    {
        $split  =   explode(':',$value);
        return $split[0].':'.$split[1];
    }

    public function getEndWednesdayAttribute($value): string
    {
        $split  =   explode(':',$value);
        return $split[0].':'.$split[1];
    }

    public function getStartThursdayAttribute($value): string
    {
        $split  =   explode(':',$value);
        return $split[0].':'.$split[1];
    }

    public function getEndThursdayAttribute($value): string
    {
        $split  =   explode(':',$value);
        return $split[0].':'.$split[1];
    }

    public function getStartFridayAttribute($value): string
    {
        $split  =   explode(':',$value);
        return $split[0].':'.$split[1];
    }

    public function getEndFridayAttribute($value): string
    {
        $split  =   explode(':',$value);
        return $split[0].':'.$split[1];
    }

    public function getStartSaturdayAttribute($value): string
    {
        $split  =   explode(':',$value);
        return $split[0].':'.$split[1];
    }

    public function getEndSaturdayAttribute($value): string
    {
        $split  =   explode(':',$value);
        return $split[0].':'.$split[1];
    }

    public function getStartSundayAttribute($value): string
    {
        $split  =   explode(':',$value);
        return $split[0].':'.$split[1];
    }

    public function getEndSundayAttribute($value): string
    {
        $split  =   explode(':',$value);
        return $split[0].':'.$split[1];
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(OrganizationImage::class)->where(MainContract::STATUS,MainContract::ON);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class)->where(MainContract::STATUS,MainContract::ON);
    }

    public function getImageAttribute() {
        return $this->attributes[MainContract::IMAGE]?$this->attributes[MainContract::IMAGE]:'/img/logo/reserved-logo.png';
    }

    public function setImageAttribute($value)
    {
        if (Str::startsWith($value, 'data:image')) {
            $image      =   Image::make($value)->encode('jpg', 100);
            $filename   =   'logo/'.md5($value.time()).'.jpg';
            Storage::disk('s3')->put($filename, $image->stream()->__toString());
            $this->attributes[MainContract::IMAGE]  =   Storage::disk('s3')->url($filename);
        }
    }

    public function setWallpaperAttribute($value)
    {
        if (Str::startsWith($value, 'data:image')) {
            $image      =   Image::make($value)->encode('jpg', 90);
            $filename   =   'wall/'.md5($value.time()).'.jpg';
            Storage::disk('s3')->put($filename, $image->stream()->__toString());
            $this->attributes[MainContract::WALLPAPER]  =   Storage::disk('s3')->url($filename);
        }
    }

}
