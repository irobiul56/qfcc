<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_id',
        'donation_id',
        'reference',
        'payment_method',
        'amount',
        'currency',
        'status',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'card_last4',
        'card_brand',
        'zelle_reference',
        'zelle_sender_name',
        'zelle_screenshot_path',
        'meta',
        'notes',
        'paid_at',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'amount'      => 'decimal:2',
        'meta'        => 'array',
        'paid_at'     => 'datetime',
        'verified_at' => 'datetime',
    ];

    /* ═══════════════════════════════════════════════════════
       BOOT — Auto-generate reference
       ═══════════════════════════════════════════════════════ */
    protected static function booted(): void
    {
        static::creating(function (Transaction $txn) {
            if (empty($txn->reference)) {
                $txn->reference = self::generateReference();
            }
        });
    }

    public static function generateReference(): string
    {
        $date  = now()->format('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return 'QFCC-TXN-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /* ═══════════════════════════════════════════════════════
       RELATIONS
       ═══════════════════════════════════════════════════════ */
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /* ═══════════════════════════════════════════════════════
       SCOPES
       ═══════════════════════════════════════════════════════ */
    public function scopePending($q)   { return $q->where('status', 'pending'); }
    public function scopeProcessing($q){ return $q->where('status', 'processing'); }
    public function scopeCompleted($q) { return $q->where('status', 'completed'); }
    public function scopeFailed($q)    { return $q->where('status', 'failed'); }
    public function scopeRefunded($q)  { return $q->where('status', 'refunded'); }
    public function scopeCancelled($q) { return $q->where('status', 'cancelled'); }

    public function scopeForMemberships($q) { return $q->whereNotNull('membership_id'); }
    public function scopeForDonations($q)   { return $q->whereNotNull('donation_id'); }

    public function scopeStripe($q) { return $q->where('payment_method', 'stripe'); }
    public function scopeZelle($q)  { return $q->where('payment_method', 'zelle'); }

    /* ═══════════════════════════════════════════════════════
       STATUS HELPERS
       ═══════════════════════════════════════════════════════ */
    public function markProcessing(): void
    {
        $this->update(['status' => 'processing']);
    }

    public function markCompleted(?int $verifiedBy = null): void
    {
        $this->update([
            'status'      => 'completed',
            'paid_at'     => $this->paid_at ?? now(),
            'verified_at' => now(),
            'verified_by' => $verifiedBy ?? Auth::id(),
        ]);
    }

    public function markFailed(string $reason = null): void
    {
        $this->update([
            'status' => 'failed',
            'notes'  => $reason,
        ]);
    }

    public function markRefunded(string $reason = null): void
    {
        $this->update([
            'status' => 'refunded',
            'notes'  => $reason,
        ]);
    }

    public function markCancelled(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    /* ═══════════════════════════════════════════════════════
       CHECK HELPERS
       ═══════════════════════════════════════════════════════ */
    public function isCompleted(): bool  { return $this->status === 'completed'; }
    public function isPending(): bool    { return $this->status === 'pending'; }
    public function isFailed(): bool     { return $this->status === 'failed'; }
    public function isRefunded(): bool   { return $this->status === 'refunded'; }
    public function isStripe(): bool     { return $this->payment_method === 'stripe'; }
    public function isZelle(): bool      { return $this->payment_method === 'zelle'; }
    public function isForDonation(): bool{ return $this->donation_id !== null; }
    public function isForMembership(): bool { return $this->membership_id !== null; }

    /* ═══════════════════════════════════════════════════════
       ACCESSORS
       ═══════════════════════════════════════════════════════ */
    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format((float) $this->amount, 2);
    }

    public function getMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'stripe' => 'Card (Stripe)',
            'zelle'  => 'Zelle',
            'bank'   => 'Bank Transfer',
            'cash'   => 'Cash',
            default  => ucfirst($this->payment_method),
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }
}