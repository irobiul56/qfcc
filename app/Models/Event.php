<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'description', 'image',
        'starts_at', 'ends_at', 'location', 'address',
        'event_type', 'is_featured', 'is_active', 'capacity',
    ];

    protected $casts = [
        'starts_at'   => 'datetime',
        'ends_at'     => 'datetime',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Event $event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title) . '-' . Str::random(5);
            }
        });
    }

    /* --- Scopes --- */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('starts_at', '>=', now())->orderBy('starts_at');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /* --- Accessors --- */
    public function getMonthAttribute(): string
    {
        return $this->starts_at ? strtoupper($this->starts_at->format('M')) : '';
    }

    public function getDayAttribute(): string
    {
        return $this->starts_at ? $this->starts_at->format('d') : '';
    }

    public function getDateLabelAttribute(): string
    {
        return $this->starts_at ? $this->starts_at->format('D, F j, Y') : '';
    }

    public function getTimeLabelAttribute(): string
    {
        if (!$this->starts_at) return '';
        $time = $this->starts_at->format('g:i A');
        return $this->location ? "{$time} · {$this->location}" : $time;
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) return '/storage/images/event-placeholder.jpg';
        if (Str::startsWith($this->image, ['http://', 'https://'])) return $this->image;
        return '/storage/' . ltrim($this->image, '/');
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->event_type) {
            'iftar'      => 'COMMUNITY GATHERING',
            'workshop'   => 'YOUTH DEVELOPMENT',
            'seminar'    => 'HEALTH & WELLNESS',
            'fundraiser' => 'FUNDRAISING',
            'outreach'   => 'COMMUNITY OUTREACH',
            default      => 'GENERAL',
        };
    }

    public function registrations()
{
    return $this->hasMany(EventRegistration::class);
}

/**
 * Total confirmed guests (includes +1 for the registrant themselves).
 */
public function confirmedGuestsCount(): int
{
    return $this->registrations()
        ->where('status', 'confirmed')
        ->get()
        ->sum(fn ($r) => 1 + (int) $r->guests);
}

/**
 * Is the event fully booked?
 */
public function isFull(): bool
{
    if (!$this->capacity) return false;
    return $this->confirmedGuestsCount() >= $this->capacity;
}

/**
 * Remaining spots (null if unlimited).
 */
public function spotsLeft(): ?int
{
    if (!$this->capacity) return null;
    return max(0, $this->capacity - $this->confirmedGuestsCount());
}
}