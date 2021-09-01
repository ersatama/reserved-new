<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\OrganizationImageContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class OrganizationImage extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable =   OrganizationImageContract::FILLABLE;

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function setImageAttribute($value)
    {
        if (Str::startsWith($value, 'data:image')) {
            $image      =   Image::make($value)->encode('jpg', 100);
            $filename   =   'img/'.md5($value.time()).'.jpg';
            Storage::disk('s3')->put($filename, $image->stream()->__toString());
            $this->attributes[MainContract::IMAGE] = Storage::disk('s3')->url($filename);
        }
    }
}
