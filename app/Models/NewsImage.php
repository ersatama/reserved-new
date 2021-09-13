<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Contracts\NewsImageContract;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class NewsImage extends Model
{
    use HasFactory;
    protected $fillable =   NewsImageContract::FILLABLE;

    public function setImageAttribute($value)
    {
        if (Str::startsWith($value, 'data:image')) {
            $image      =   Image::make($value)->encode('jpg', 100);
            $filename   =   'img/'.md5($value.time()).'.jpg';
            Storage::disk('s3')->put($filename, $image->stream()->__toString());
            $this->attributes[MainContract::IMAGE]  =   Storage::disk('s3')->url($filename);
        }
    }
}
