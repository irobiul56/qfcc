<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationCampaign;
use App\Models\Transaction;
use App\Services\DonationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DonationController extends Controller
{
    public function __construct(
        protected DonationService $donations
    ) {}

    /**
     * Admin dashboard — list all donations.
     */
    public function index(Request $request): Response
    {
        $query = Donation::with(['campaign:id,title,slug', 'transaction'])
            ->latest();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by campaign
        if ($campaignId = $request->input('campaign_id')) {
            $query->where('donation_campaign_id', $campaignId);
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filter by payment method
        if ($method = $request->input('payment_method')) {
            $query->where('payment_method', $method);
        }

        // Filter by type
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // ─── Stats ───
        $stats = [
            'total_completed'  => (float) Donation::completed()->sum('amount'),
            'total_pending'    => (float) Donation::pending()->sum('amount'),
            'total_refunded'   => (float) Donation::refunded()->sum('amount'),
            'donors_count'     => Donation::completed()->distinct('email')->count('email'),
            'today'            => (float) Donation::completed()->whereDate('created_at', today())->sum('amount'),
            'this_month'       => (float) Donation::completed()->whereMonth('created_at', now()->month)->sum('amount'),
        ];

        return Inertia::render('Dashboard/Donations/Index', [
            'donations' => $query->paginate(20)->withQueryString(),
            'stats'     => $stats,
            'campaigns' => DonationCampaign::orderBy('title')->get(['id', 'title']),
            'filters'   => [
                'search'         => $request->input('search', ''),
                'status'         => $request->input('status', ''),
                'campaign_id'    => $request->input('campaign_id', ''),
                'payment_method' => $request->input('payment_method', ''),
                'type'           => $request->input('type', ''),
            ],
        ]);
    }

    /**
     * Admin — verify a pending transaction.
     */
    public function verify(Transaction $transaction)
    {
        abort_unless(Auth::check(), 403);

        $this->donations->verifyPending($transaction, Auth::id());

        return back()->with('success', "Transaction {$transaction->reference} verified and confirmed.");
    }

    /**
     * Admin — refund a completed donation.
     */
    public function refund(Request $request, Transaction $transaction)
    {
        abort_unless(Auth::check(), 403);

        $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $this->donations->refund($transaction, $request->input('reason'));

        return back()->with('success', "Transaction {$transaction->reference} refunded.");
    }

    /**
     * Admin — delete a donation (soft delete).
     */
    public function destroy(Donation $donation)
    {
        abort_unless(Auth::check(), 403);

        $donation->delete();

        return back()->with('success', 'Donation deleted.');
    }

    /**
     * Admin — export donations as CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $filename = 'donations-' . now()->format('Y-m-d') . '.csv';

        $query = Donation::with(['campaign:id,title', 'transaction']);

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($campaignId = $request->input('campaign_id')) {
            $query->where('donation_campaign_id', $campaignId);
        }
        if ($method = $request->input('payment_method')) {
            $query->where('payment_method', $method);
        }
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'ID', 'Reference', 'Campaign', 'Donor Name', 'Email', 'Phone',
                'Amount', 'Currency', 'Type', 'Status', 'Payment Method',
                'Anonymous', 'Message', 'Created At',
            ]);

            $query->chunk(500, function ($chunk) use ($handle) {
                foreach ($chunk as $d) {
                    fputcsv($handle, [
                        $d->id,
                        $d->transaction?->reference,
                        $d->campaign?->title,
                        $d->donor_name,
                        $d->email,
                        $d->phone,
                        $d->amount,
                        $d->currency,
                        $d->type,
                        $d->status,
                        $d->payment_method,
                        $d->is_anonymous ? 'Yes' : 'No',
                        $d->message,
                        $d->created_at->toDateTimeString(),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}