<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Snack extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_produk',
        'gula',
        'natrium',
        'lemak',
        'serat',
        'hasil_klasifikasi',
        'method',
    ];

    protected $casts = [
        'gula'    => 'decimal:2',
        'natrium' => 'decimal:2',
        'lemak'   => 'decimal:2',
        'serat'   => 'decimal:2',
    ];

    // ── Relasi ─────────────────────────────────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(History::class);
    }

    // ── Scope ──────────────────────────────────────────────────────────────────
    public function scopeSehat($query)
    {
        return $query->where('hasil_klasifikasi', 'Snack Sehat');
    }

    public function scopePerluPerhatian($query)
    {
        return $query->where('hasil_klasifikasi', 'Perlu Perhatian');
    }

    public function scopeKlaimDiragukan($query)
    {
        return $query->where('hasil_klasifikasi', 'Klaim Sehat Diragukan');
    }

    // scope milik user tertentu
    public function scopeOwnedBy($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ── Accessor ───────────────────────────────────────────────────────────────
    public function getBadgeColorAttribute(): string
    {
        return match ($this->hasil_klasifikasi) {
            'Snack Sehat'           => 'success',
            'Perlu Perhatian'       => 'warning',
            'Klaim Sehat Diragukan' => 'danger',
            default                 => 'secondary',
        };
    }
}