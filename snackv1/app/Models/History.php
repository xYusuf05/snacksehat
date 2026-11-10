<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'snack_id',
        'user_id',
        'hasil',
        'detail_input',
        'confidence',
        'method',
    ];

    protected $casts = [
        'detail_input' => 'array',
        'confidence'   => 'array',
    ];

    // ─── Relasi ────────────────────────────────────────────────────────────────
    public function snack(): BelongsTo
    {
        return $this->belongsTo(Snack::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ─── Accessor ──────────────────────────────────────────────────────────────
    public function getBadgeColorAttribute(): string
    {
        return match ($this->hasil) {
            'Snack Sehat'           => 'success',
            'Perlu Perhatian'       => 'warning',
            'Klaim Sehat Diragukan' => 'danger',
            default                 => 'secondary',
        };
    }
}