<?php

namespace App\Models;

use App\Models\Checklist;
use App\Models\Tag;
use App\Models\Notepad;
use App\Models\Comment;
use App\Models\Traits\UuidAsKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{
    use HasFactory, UuidAsKey;

    protected $primaryKey = "id";
    protected $keyType = "string";
    protected $guarded = [];

    public function checklists(): HasMany
    {
        return $this->hasMany(Checklist::class);
    }
    
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    
    public function notepads(): HasMany
    {
        return $this->hasMany(Notepad::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
    
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
