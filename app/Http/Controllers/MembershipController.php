<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class MembershipController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Membership/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'membership_type'       => ['required', 'in:General Member,Lifetime Member'],
            'full_name'             => ['required', 'string', 'max:255'],
            'dob'                   => ['nullable', 'date'],
            'gender'                => ['nullable', 'string', 'max:50'],
            'marital_status'        => ['nullable', 'string', 'max:50'],
            'occupation'            => ['nullable', 'string', 'max:255'],
            'address'               => ['nullable', 'string', 'max:255'],
            'city'                  => ['nullable', 'string', 'max:100'],
            'state'                 => ['nullable', 'string', 'max:100'],
            'zip'                   => ['nullable', 'string', 'max:20'],
            'phone'                 => ['nullable', 'string', 'max:30'],
            'email'                 => ['nullable', 'email', 'max:255'],
            'skills'                => ['nullable', 'string'],
            'spouse_name'           => ['nullable', 'string', 'max:255'],
            'spouse_dob'            => ['nullable', 'date'],
            'spouse_occupation'     => ['nullable', 'string', 'max:255'],
            'children'              => ['nullable', 'array'],
            'children.*.fullName'   => ['nullable', 'string', 'max:255'],
            'children.*.dob'        => ['nullable', 'date'],
            'children.*.gender'     => ['nullable', 'string', 'max:50'],
            'children.*.occupation' => ['nullable', 'string', 'max:255'],
            'emergency_name'         => ['nullable', 'string', 'max:255'],
            'emergency_relationship' => ['nullable', 'string', 'max:100'],
            'emergency_phone'        => ['nullable', 'string', 'max:30'],
            'emergency_email'        => ['nullable', 'email', 'max:255'],
        ]);

        $validated['children'] = collect($validated['children'] ?? [])
            ->filter(fn ($child) => !empty(array_filter($child)))
            ->values()
            ->all();

        // ✅ Use transaction to keep DB consistent
        $membership = DB::transaction(function () use ($validated) {
            $membership = Membership::create($validated);

            // Create a pending transaction record
            Transaction::create([
                'membership_id'   => $membership->id,
                'payment_method'  => 'stripe', // default; will update on confirm
                'amount'          => $membership->amount,
                'currency'        => 'USD',
                'status'          => 'pending',
            ]);

            return $membership;
        });

        return response()->json([
            'success'    => true,
            'membership' => [
                'id'              => $membership->id,
                'membership_type' => $membership->membership_type,
                'amount'          => (float) $membership->amount,
                'full_name'       => $membership->full_name,
                'email'           => $membership->email,
            ],
        ]);
    }

    public function confirmPayment(Request $request, Membership $membership)
    {
        $validated = $request->validate([
            'payment_method' => ['required', 'string', 'in:stripe,zelle'],
            'card_last4'     => ['nullable', 'string', 'max:4'],
            'card_brand'     => ['nullable', 'string', 'max:20'],
            'zelle_reference'=> ['nullable', 'string', 'max:100'],
        ]);

        // Get the pending transaction
        $transaction = $membership->transactions()
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'No pending transaction found for this membership.',
            ], 404);
        }

        DB::transaction(function () use ($transaction, $membership, $validated) {
            // Update transaction with method-specific details
            $transaction->update([
                'payment_method' => $validated['payment_method'],
                'card_last4'     => $validated['payment_method'] === 'stripe'
                    ? ($validated['card_last4'] ?? null) : null,
                'card_brand'     => $validated['payment_method'] === 'stripe'
                    ? ($validated['card_brand'] ?? null) : null,
                'zelle_reference'=> $validated['payment_method'] === 'zelle'
                    ? ($validated['zelle_reference'] ?? null) : null,
                'status'         => $validated['payment_method'] === 'stripe'
                    ? 'completed'
                    : 'processing',
                'paid_at'        => now(),
            ]);

            // Update membership status
            $membership->update([
                'status' => $validated['payment_method'] === 'stripe' ? 'approved' : 'pending',
            ]);
        });

        $message = $validated['payment_method'] === 'stripe'
            ? "Payment successful! Welcome to QFCC — Membership #{$membership->id}."
            : "Payment noted! We'll verify your Zelle transfer within 24 hours.";

        return response()->json([
            'success'       => true,
            'message'       => $message,
            'reference'     => $transaction->reference,
            'redirect'      => route('membership.create'),
        ]);
    }

    public function index(): Response
    {
        return Inertia::render('Membership/Index', [
            'memberships' => Membership::with('latestTransaction')
                ->latest()
                ->paginate(20),
        ]);
    }
}