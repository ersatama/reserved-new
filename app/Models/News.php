<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Contracts\NewsContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class News extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   NewsContract::FILLABLE;

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function newsImages(): HasMany
    {
        return $this->hasMany(NewsImage::class)
            ->where(MainContract::STATUS,MainContract::ON);
    }

}
