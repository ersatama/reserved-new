<?php

namespace App\Models;

use App\Domain\Contracts\CategoryContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class Category extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   CategoryContract::FILLABLE;

    public function setImageAttribute($value) {

        $disk               =   config('backpack.base.root_disk_name');
        $destination_path   =   'public/uploads';

        if ($value  ==  null) {

            Storage::disk($disk)->delete($this->{MainContract::IMAGE});
            $this->attributes[MainContract::IMAGE] = null;

        }

        if (Str::startsWith($value, 'data:image')) {

            $image      =   Image::make($value)->encode('png')->resize(150,150);
            $filename   =   md5($value.time()).'.png';
            Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            Storage::disk($disk)->delete($this->{MainContract::IMAGE});
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[MainContract::IMAGE] = '/'.$public_destination_path.'/'.$filename;

        }
    }

    public function setWallpaperAttribute($value) {

        $disk               =   config('backpack.base.root_disk_name');
        $destination_path   =   'public/uploads';

        if ($value  ==  null) {

            Storage::disk($disk)->delete($this->{MainContract::WALLPAPER});
            $this->attributes[MainContract::WALLPAPER] = null;

        }

        if (Str::startsWith($value, 'data:image')) {

            $image      =   Image::make($value)->encode('jpg', 90);
            $filename   =   md5($value.time()).'.jpg';
            Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            Storage::disk($disk)->delete($this->{MainContract::WALLPAPER});
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[MainContract::WALLPAPER] = '/'.$public_destination_path.'/'.$filename;

        }
    }
}
