<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'donation_campaign_id',
        'donor_name',
        'email',
        'phone',
        'amount',
        'currency',
        'type',
        'status',
        'payment_method',
        'message',
        'is_anonymous',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'is_anonymous' => 'boolean',
    ];

    /* ═══════════════════════════════════════════════════════
       RELATIONS
       ═══════════════════════════════════════════════════════ */
    public function campaign()
    {
        return $this->belongsTo(DonationCampaign::class, 'donation_campaign_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /* ═══════════════════════════════════════════════════════
       SCOPES
       ═══════════════════════════════════════════════════════ */
    public function scopeCompleted($q) { return $q->where('status', 'completed'); }
    public function scopePending($q)   { return $q->where('status', 'pending'); }
    public function scopeFailed($q)    { return $q->where('status', 'failed'); }
    public function scopeRefunded($q)  { return $q->where('status', 'refunded'); }

    public function scopeOneTime($q)   { return $q->where('type', 'one_time'); }
    public function scopeMonthly($q)   { return $q->where('type', 'monthly'); }

    public function scopeAnonymous($q) { return $q->where('is_anonymous', true); }

    public function scopeForCampaign($q, $campaignId) {
        return $q->where('donation_campaign_id', $campaignId);
    }

    /* ═══════════════════════════════════════════════════════
       HELPERS
       ═══════════════════════════════════════════════════════ */
    public function isCompleted(): bool { return $this->status === 'completed'; }
    public function isPending(): bool   { return $this->status === 'pending'; }

    public function getDisplayNameAttribute(): string
    {
        return $this->is_anonymous ? 'Anonymous' : ($this->donor_name ?: 'Anonymous');
    }

    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format((float) $this->amount, 2);
    }
}