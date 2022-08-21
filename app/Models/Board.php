<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Traits\UuidAsKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    use HasFactory, UuidAsKey;

    protected $primaryKey = "id";
    protected $keyType = "string";
    protected $guarded = [];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, "author_id");
    }

    public function folders(): HasMany
    {
        return $this->hasMany(Folder::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
