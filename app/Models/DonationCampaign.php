<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DonationCampaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'goal_amount',
        'raised_amount',
        'start_date',
        'end_date',
        'is_active',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'goal_amount'   => 'decimal:2',
        'raised_amount' => 'decimal:2',
        'start_date'    => 'date',
        'end_date'      => 'date',
        'is_active'     => 'boolean',
        'is_featured'   => 'boolean',
        'order'         => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (DonationCampaign $campaign) {
            if (empty($campaign->slug)) {
                $campaign->slug = Str::slug($campaign->title) . '-' . Str::random(5);
            }
        });
    }

    /* ═══════════════════════════════════════════════════════
       RELATIONS
       ═══════════════════════════════════════════════════════ */
    public function donations()
    {
        return $this->hasMany(Donation::class, 'donation_campaign_id');
    }

    public function completedDonations()
    {
        return $this->hasMany(Donation::class, 'donation_campaign_id')
                    ->where('status', 'completed');
    }

    public function pendingDonations()
    {
        return $this->hasMany(Donation::class, 'donation_campaign_id')
                    ->where('status', 'pending');
    }

    /* ═══════════════════════════════════════════════════════
       SCOPES
       ═══════════════════════════════════════════════════════ */
    public function scopeActive($q)   { return $q->where('is_active', true); }
    public function scopeFeatured($q) { return $q->where('is_featured', true); }
    public function scopeOrdered($q)  { return $q->orderBy('order')->orderByDesc('created_at'); }

    /* ═══════════════════════════════════════════════════════
       ACCESSORS
       ═══════════════════════════════════════════════════════ */
    public function getImageUrlAttribute(): string
    {
        if (!$this->image) return '/storage/images/campaign-placeholder.jpg';
        if (Str::startsWith($this->image, ['http://', 'https://'])) return $this->image;
        return '/storage/' . ltrim($this->image, '/');
    }

    public function getProgressPercentAttribute(): float
    {
        if (!$this->goal_amount || $this->goal_amount <= 0) return 0;
        return min(100, round(($this->raised_amount / $this->goal_amount) * 100, 1));
    }

    public function getRemainingAmountAttribute(): float
    {
        return max(0, (float) $this->goal_amount - (float) $this->raised_amount);
    }

    /* ═══════════════════════════════════════════════════════
       HELPERS
       ═══════════════════════════════════════════════════════ */
    /**
     * Recalculate raised_amount from completed donations.
     */
    public function syncRaisedAmount(): void
    {
        $this->update([
            'raised_amount' => $this->completedDonations()->sum('amount'),
        ]);
    }
}