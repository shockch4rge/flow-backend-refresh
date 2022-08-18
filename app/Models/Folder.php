<?php

namespace App\Models;

use App\Models\Traits\UuidAsKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Folder extends Model
{
    use HasFactory, UuidAsKey;

    protected $primaryKey = "id";
    protected $keyType = "string";
    protected $guarded = [];


    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);

    }
}
