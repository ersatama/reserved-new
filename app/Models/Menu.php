<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Contracts\MenuContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class Menu extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   MenuContract::FILLABLE;

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class,MainContract::ORGANIZATION_ID,MainContract::ID);
    }

    public function setImageAttribute($value)
    {
        if (Str::startsWith($value, 'data:image'))
        {
            $image      =   Image::make($value)->encode('jpg', 100);
            $filename   =   'menu/'.md5($value.time()).'.jpg';
            Storage::disk('s3')->put($filename, $image->stream()->__toString());
            $this->attributes[MainContract::IMAGE] = Storage::disk('s3')->url($filename);
        }
    }

}
