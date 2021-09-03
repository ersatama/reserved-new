<?php

namespace App\Models;

use App\Domain\Contracts\TagsOptionContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TagsOption extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   TagsOptionContract::FILLABLE;
    public function tags(): BelongsTo
    {
        return $this->belongsTo(Tags::class);
    }
}
