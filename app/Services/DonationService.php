<?php

namespace App\Services;

use App\Models\Donation;
use App\Models\DonationCampaign;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DonationService
{
    /* ═══════════════════════════════════════════════════════
       CREATE — Pending donation + pending transaction
       ═══════════════════════════════════════════════════════ */

    /**
     * Create a pending donation and pending transaction together.
     *
     * @param  DonationCampaign  $campaign
     * @param  array             $data
     * @return array{donation: Donation, transaction: Transaction}
     */
    public function createPendingDonation(DonationCampaign $campaign, array $data): array
    {
        return DB::transaction(function () use ($campaign, $data) {
            // 1. Create the donation (pending) — linked to campaign
            $donation = Donation::create([
                'donation_campaign_id' => $campaign->id,
                'donor_name'           => $data['donor_name'] ?? null,
                'email'                => $data['email'],
                'phone'                => $data['phone'] ?? null,
                'amount'               => $data['amount'],
                'currency'             => $data['currency'] ?? 'USD',
                'type'                 => $data['type'] ?? 'one_time',
                'status'               => 'pending',
                'payment_method'       => $data['payment_method'],
                'message'              => $data['message'] ?? null,
                'is_anonymous'         => $data['is_anonymous'] ?? false,
            ]);

            // 2. Create the transaction (pending)
            $transaction = Transaction::create([
                'donation_id'    => $donation->id,
                'payment_method' => $data['payment_method'],
                'amount'         => $data['amount'],
                'currency'       => $data['currency'] ?? 'USD',
                'status'         => 'pending',
                'meta'           => [
                    'campaign_id'   => $campaign->id,
                    'campaign_slug' => $campaign->slug,
                ],
                'notes'          => 'Pending ' . ucfirst($data['payment_method']) . ' payment',
            ]);

            Log::info('Pending donation created', [
                'donation_id'    => $donation->id,
                'transaction_id' => $transaction->id,
                'reference'      => $transaction->reference,
                'campaign'       => $campaign->slug,
                'amount'         => $donation->amount,
            ]);

            return [
                'donation'    => $donation,
                'transaction' => $transaction,
            ];
        });
    }

    /* ═══════════════════════════════════════════════════════
       STATUS — Completed / Failed / Refunded
       ═══════════════════════════════════════════════════════ */

    /**
     * Mark a transaction (and its donation) as completed.
     * Also increments the campaign's raised_amount.
     */
    public function markCompleted(Transaction $transaction, ?int $verifiedBy = null, array $extra = []): void
    {
        DB::transaction(function () use ($transaction, $verifiedBy, $extra) {
            // 1. Update transaction
            $transaction->update([
                'status'                   => 'completed',
                'paid_at'                  => $transaction->paid_at ?? now(),
                'verified_at'              => now(),
                'verified_by'              => $verifiedBy ?? Auth::id(),
                'stripe_payment_intent_id' => $extra['stripe_payment_intent_id'] ?? $transaction->stripe_payment_intent_id,
                'stripe_charge_id'         => $extra['stripe_charge_id'] ?? $transaction->stripe_charge_id,
                'card_last4'               => $extra['card_last4'] ?? $transaction->card_last4,
                'card_brand'               => $extra['card_brand'] ?? $transaction->card_brand,
                'zelle_reference'          => $extra['zelle_reference'] ?? $transaction->zelle_reference,
                'zelle_sender_name'        => $extra['zelle_sender_name'] ?? $transaction->zelle_sender_name,
            ]);

            // 2. Update donation
            $donation = $transaction->donation;
            if ($donation) {
                $donation->update(['status' => 'completed']);

                // 3. Increment the campaign's raised_amount
                if ($donation->donation_campaign_id) {
                    DonationCampaign::where('id', $donation->donation_campaign_id)
                        ->increment('raised_amount', $transaction->amount);
                }
            }

            Log::info('Transaction completed', [
                'reference' => $transaction->reference,
                'amount'    => $transaction->amount,
            ]);
        });
    }

    /**
     * Mark a transaction (and its donation) as failed.
     */
    public function markFailed(Transaction $transaction, string $reason = null): void
    {
        DB::transaction(function () use ($transaction, $reason) {
            $transaction->update([
                'status' => 'failed',
                'notes'  => $reason,
            ]);

            if ($transaction->donation) {
                $transaction->donation->update(['status' => 'failed']);
            }

            Log::warning('Transaction failed', [
                'reference' => $transaction->reference,
                'reason'    => $reason,
            ]);
        });
    }

    /**
     * Refund a completed transaction and cascade.
     */
    public function refund(Transaction $transaction, string $reason = null): void
    {
        DB::transaction(function () use ($transaction, $reason) {
            $wasCompleted = $transaction->status === 'completed';

            $transaction->update([
                'status' => 'refunded',
                'notes'  => $reason,
            ]);

            $donation = $transaction->donation;
            if ($donation) {
                $donation->update(['status' => 'refunded']);

                // Decrement campaign raised_amount if previously incremented
                if ($wasCompleted && $donation->donation_campaign_id) {
                    DonationCampaign::where('id', $donation->donation_campaign_id)
                        ->decrement('raised_amount', $transaction->amount);
                }
            }

            Log::info('Transaction refunded', [
                'reference' => $transaction->reference,
                'reason'    => $reason,
            ]);
        });
    }

    /**
     * Mark a transaction as cancelled.
     */
    public function cancel(Transaction $transaction, string $reason = null): void
    {
        DB::transaction(function () use ($transaction, $reason) {
            $transaction->update([
                'status' => 'cancelled',
                'notes'  => $reason,
            ]);

            if ($transaction->donation && $transaction->donation->status === 'pending') {
                $transaction->donation->update(['status' => 'failed']);
            }
        });
    }

    /* ═══════════════════════════════════════════════════════
       VERIFICATION — Manual admin verification (Zelle/Bank)
       ═══════════════════════════════════════════════════════ */

    /**
     * Verify a pending transaction manually (admin action for Zelle/Bank).
     */
    public function verifyPending(Transaction $transaction, ?int $verifiedBy = null, array $extra = []): bool
    {
        if (!$transaction->isPending()) {
            Log::warning('Attempted to verify a non-pending transaction', [
                'reference' => $transaction->reference,
                'status'    => $transaction->status,
            ]);
            return false;
        }

        $this->markCompleted($transaction, $verifiedBy, $extra);

        return true;
    }

    /* ═══════════════════════════════════════════════════════
       REPORTING HELPERS
       ═══════════════════════════════════════════════════════ */

    /**
     * Total completed donations for a campaign.
     */
    public function totalForCampaign(DonationCampaign $campaign): float
    {
        return (float) $campaign->completedDonations()->sum('amount');
    }

    /**
     * Global donation statistics.
     */
    public function globalStats(): array
    {
        return [
            'total_completed' => (float) Donation::completed()->sum('amount'),
            'total_pending'   => (float) Donation::pending()->sum('amount'),
            'donor_count'     => Donation::completed()->distinct('email')->count('email'),
            'today'           => (float) Donation::completed()
                                    ->whereDate('created_at', today())
                                    ->sum('amount'),
            'this_month'      => (float) Donation::completed()
                                    ->whereMonth('created_at', now()->month)
                                    ->sum('amount'),
        ];
    }

    /**
     * Recent completed donations.
     */
    public function recentDonations(int $limit = 10)
    {
        return Donation::with(['campaign', 'transaction'])
            ->completed()
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Pending transactions awaiting verification.
     */
    public function pendingVerifications()
    {
        return Transaction::pending()
            ->with('donation')
            ->latest()
            ->get();
    }
}