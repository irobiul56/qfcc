<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisionMission extends Model
{
    use HasFactory;

    protected $table = 'visions_missions';

    protected $fillable = [
        'type',
        'heading',
        'content',
        'icon',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    /* ═══════════════════════════════════════════════════════
       SCOPES — এগুলো থাকতেই হবে
       ═══════════════════════════════════════════════════════ */
    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function scopeVision($q)
    {
        return $q->where('type', 'vision');
    }

    public function scopeMission($q)
    {
        return $q->where('type', 'mission');
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('order')->orderBy('id');
    }

    /* ═══════════════════════════════════════════════════════
       ACCESSORS
       ═══════════════════════════════════════════════════════ */
    public function getTypeLabelAttribute(): string
    {
        return ucfirst($this->type);
    }
}