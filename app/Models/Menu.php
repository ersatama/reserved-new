<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Contracts\MenuContract;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class Menu extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   MenuContract::FILLABLE;

    public function organization()
    {
        return $this->belongsTo(Organization::class,MenuContract::ORGANIZATION_ID,MenuContract::ID);
    }

    public function setImageAttribute($value)
    {
        $disk               =   config('backpack.base.root_disk_name');
        $destination_path   =   'public/uploads';
        if (is_null($value)) {
            Storage::disk($disk)->delete($this->{MenuContract::IMAGE});
            $this->attributes[MenuContract::IMAGE] = null;
        }
        if (Str::startsWith($value, 'data:image'))
        {
            $image = Image::make($value)->encode('jpg', 90);
            $filename = md5($value.time()).'.jpg';
            Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            Storage::disk($disk)->delete($this->{MenuContract::IMAGE});
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[MenuContract::IMAGE] = '/'.$public_destination_path.'/'.$filename;
        }
    }

}
