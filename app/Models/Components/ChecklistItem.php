<?php

namespace App\Models\Components;

use App\Models\Card;
use App\Models\Traits\UuidAsKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChecklistItem extends Model {
    use HasFactory, UuidAsKey;

    protected $primaryKey = "id";
    protected $keyType = "string";
    protected $guarded = [];

    public function checklist(): BelongsTo
    {
        return $this->belongsTo(ChecklistItem::class);
    }
}
