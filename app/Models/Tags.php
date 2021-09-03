<?php

namespace App\Models;

use App\Domain\Contracts\TagsContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tags extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   TagsContract::FILLABLE;

    public function tagsOption(): HasMany
    {
        return $this->hasMany(TagsOption::class);
    }
}
