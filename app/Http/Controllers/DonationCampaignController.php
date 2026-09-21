<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DonationCampaign;
use App\Models\Transaction;
use App\Services\DonationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class DonationCampaignController extends Controller
{
    protected DonationService $donations;

    public function __construct(DonationService $donations)
    {
        $this->donations = $donations;
    }

    /**
     * Display a listing of campaigns.
     */
    public function index(Request $request)
    {
        $query = DonationCampaign::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            match ($status) {
                'active' => $query->where('is_active', true),
                'inactive' => $query->where('is_active', false),
                'featured' => $query->where('is_featured', true),
                'completed' => $query->whereColumn('raised_amount', '>=', 'goal_amount'),
                'ongoing' => $query->whereColumn('raised_amount', '<', 'goal_amount'),
                default => null,
            };
        }

        // Sort
        $sort = $request->input('sort', 'order');
        match ($sort) {
            'title' => $query->orderBy('title'),
            'newest' => $query->latest(),
            'oldest' => $query->oldest(),
            'goal_high' => $query->orderByDesc('goal_amount'),
            'goal_low' => $query->orderBy('goal_amount'),
            'raised_high' => $query->orderByDesc('raised_amount'),
            default => $query->orderBy('order')->orderBy('title'),
        };

        $campaigns = $query->paginate(10)->withQueryString();

        // Stats
        $stats = [
            'total' => DonationCampaign::count(),
            'active' => DonationCampaign::where('is_active', true)->count(),
            'featured' => DonationCampaign::where('is_featured', true)->count(),
            'total_goal' => DonationCampaign::sum('goal_amount'),
            'total_raised' => DonationCampaign::sum('raised_amount'),
        ];

        return Inertia::render('Dashboard/DonationCampaigns/Index', [
            'campaigns' => $campaigns,
            'stats' => $stats,
            'filters' => [
                'search' => $request->input('search', ''),
                'status' => $request->input('status', 'all'),
                'sort' => $request->input('sort', 'order'),
            ],
        ]);
    }

      public function create()
    {
        // Featured campaign (optional — for hero highlight)
        $featured = DonationCampaign::active()->featured()->ordered()->first();

        // All active campaigns, ordered
        $campaigns = DonationCampaign::active()
            ->ordered()
            ->get()
            ->map(fn (DonationCampaign $c) => [
                'id'               => $c->id,
                'slug'             => $c->slug,
                'title'            => $c->title,
                'description'      => $c->description,
                'image'            => $c->image_url,
                'goal_amount'      => (float) $c->goal_amount,
                'raised_amount'    => (float) $c->raised_amount,
                'progress_percent' => $c->progress_percent,
                'remaining_amount' => $c->remaining_amount,
                'is_featured'      => $c->is_featured,
                'link'             => route('donate.campaign', $c->slug),
            ]);

        // Aggregate stats for the hero
        $stats = [
            'total_raised' => (float) DonationCampaign::active()->sum('raised_amount'),
            'total_goal'   => (float) DonationCampaign::active()->sum('goal_amount'),
            'campaign_count' => DonationCampaign::active()->count(),
        ];

        return Inertia::render('Donate', [
            'campaigns' => $campaigns,
            'featured'  => $featured,
            'stats'     => $stats,
        ]);
    }

     /**
     * Single campaign detail page.
     */
    public function show(DonationCampaign $campaign)
    {
        abort_unless($campaign->is_active, 404);

        // Related campaigns (active, not the current one, ordered, limit 3)
        $related = DonationCampaign::active()
            ->where('id', '!=', $campaign->id)
            ->ordered()
            ->limit(3)
            ->get()
            ->map(fn (DonationCampaign $c) => [
                'id'               => $c->id,
                'slug'             => $c->slug,
                'title'            => $c->title,
                'description'      => $c->description,
                'image'            => $c->image_url,
                'goal_amount'      => (float) $c->goal_amount,
                'raised_amount'    => (float) $c->raised_amount,
                'progress_percent' => $c->progress_percent,
                'link'             => route('donate.campaign', $c->slug),
            ]);

        return Inertia::render('Donate/Show', [
            'campaign' => [
                'id'               => $campaign->id,
                'slug'             => $campaign->slug,
                'title'            => $campaign->title,
                'description'      => $campaign->description,
                'image'            => $campaign->image_url,
                'goal_amount'      => (float) $campaign->goal_amount,
                'raised_amount'    => (float) $campaign->raised_amount,
                'progress_percent' => $campaign->progress_percent,
                'remaining_amount' => $campaign->remaining_amount,
                'start_date'       => $campaign->start_date?->format('F j, Y'),
                'end_date'         => $campaign->end_date?->format('F j, Y'),
                'is_featured'      => $campaign->is_featured,
                'created_at'       => $campaign->created_at->format('F j, Y'),
            ],
            'related' => $related,
        ]);
    }

    /**
     * Store a newly created campaign.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:donation_campaigns,slug'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'goal_amount' => ['required', 'numeric', 'min:0'],
            'raised_amount' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('campaigns', 'public');
        }

        $validated['raised_amount'] = $validated['raised_amount'] ?? 0;
        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? (DonationCampaign::max('order') + 1);

        DonationCampaign::create($validated);

        return redirect()
            ->route('campaigns.index')
            ->with('success', 'Campaign created successfully.');
    }


      public function donatestore(Request $request, DonationCampaign $campaign)
    {
        $validated = Validator::make($request->all(), [
            'full_name'       => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'max:255'],
            'phone'           => ['nullable', 'string', 'max:30'],
            'note'            => ['nullable', 'string', 'max:1000'],
            'amount'          => ['required', 'numeric', 'min:1', 'max:100000'],
            'payment_method'  => ['required', 'in:stripe,zelle'],
        ])->validate();

        if (!$campaign->is_active) {
            return $this->errorResponse('This campaign is no longer accepting donations.', 422);
        }

        try {
            if ($validated['payment_method'] === 'stripe') {
                return $this->handleStripe($campaign, $validated);
            }

            if ($validated['payment_method'] === 'zelle') {
                return $this->handleZelle($campaign, $validated);
            }

            return $this->errorResponse('Unsupported payment method.', 422);
        } catch (\Throwable $e) {
            Log::error('Donation failed', [
                'campaign_id' => $campaign->id,
                'error'       => $e->getMessage(),
                'trace'       => $e->getTraceAsString(),
            ]);

            return $this->errorResponse(
                config('app.debug') ? $e->getMessage() : 'Payment could not be processed.',
                500
            );
        }
    }

    protected function handleStripe(DonationCampaign $campaign, array $data)
    {
        $result = $this->donations->createPendingDonation($campaign, [
            'donor_name'     => $data['full_name'],
            'email'          => $data['email'],
            'phone'          => $data['phone'] ?? null,
            'message'        => $data['note'] ?? null,
            'amount'         => $data['amount'],
            'currency'       => 'USD',
            'type'           => 'one_time',
            'is_anonymous'   => false,
            'payment_method' => 'stripe',
        ]);

        try {
            $stripeClientClass = 'Stripe\\StripeClient';
            $stripe = new $stripeClientClass(config('services.stripe.secret'));

            $session = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'mode'                 => 'payment',
                'customer_email'       => $data['email'],
                'line_items'           => [[
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name'        => $campaign->title,
                            'description' => 'Donation to ' . $campaign->title,
                        ],
                        'unit_amount'  => (int) round($data['amount'] * 100),
                    ],
                    'quantity'   => 1,
                ]],
                'metadata'             => [
                    'donation_id'    => $result['donation']->id,
                    'transaction_id' => $result['transaction']->id,
                    'campaign_id'    => $campaign->id,
                    'donor_name'     => $data['full_name'],
                    'email'          => $data['email'],
                ],
                'success_url'          => route('donate.success', $result['transaction']->reference) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'           => route('donate.show', $campaign->slug),
            ]);

            $result['transaction']->update([
                'stripe_payment_intent_id' => $session->id,
                'status'                   => 'processing',
            ]);

            return response()->json([
                'success'      => true,
                'checkout_url' => $session->url,
                'reference'    => $result['transaction']->reference,
            ]);
        } catch (\Throwable $e) {
            $result['transaction']->markFailed('Stripe session creation failed: ' . $e->getMessage());
            $result['donation']->update(['status' => 'failed']);
            throw $e;
        }
    }

    protected function handleZelle(DonationCampaign $campaign, array $data)
    {
        $result = $this->donations->createPendingDonation($campaign, [
            'donor_name'     => $data['full_name'],
            'email'          => $data['email'],
            'phone'          => $data['phone'] ?? null,
            'message'        => $data['note'] ?? null,
            'amount'         => $data['amount'],
            'currency'       => 'USD',
            'type'           => 'one_time',
            'is_anonymous'   => false,
            'payment_method' => 'zelle',
        ]);

        return response()->json([
            'success'   => true,
            'reference' => $result['transaction']->reference,
            'message'   => 'Your Zelle donation has been recorded. We will verify and confirm it within 24 hours.',
        ]);
    }

    public function success(string $reference)
    {
        $transaction = Transaction::where('reference', $reference)
            ->with('donation')
            ->firstOrFail();

        return Inertia::render('Donate/Success', [
            'transaction' => [
                'reference'      => $transaction->reference,
                'amount'         => (float) $transaction->amount,
                'status'         => $transaction->status,
                'payment_method' => $transaction->payment_method,
                'donation'       => $transaction->donation ? [
                    'id'         => $transaction->donation->id,
                    'donor_name' => $transaction->donation->donor_name,
                    'email'      => $transaction->donation->email,
                ] : null,
            ],
        ]);
    }

    protected function errorResponse(string $message, int $status = 422)
    {
        return response()->json(['success' => false, 'message' => $message], $status);
    }
    /**
     * Update the specified campaign.
     */
    public function update(Request $request, DonationCampaign $campaign)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('donation_campaigns', 'slug')->ignore($campaign->id)],
            'description' => ['required', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'goal_amount' => ['required', 'numeric', 'min:0'],
            'raised_amount' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle image
        if ($request->hasFile('image')) {
            if ($campaign->image) {
                Storage::disk('public')->delete($campaign->image);
            }
            $validated['image'] = $request->file('image')->store('campaigns', 'public');
        } elseif ($request->boolean('remove_image')) {
            if ($campaign->image) {
                Storage::disk('public')->delete($campaign->image);
            }
            $validated['image'] = null;
        }

        unset($validated['remove_image']);

        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['raised_amount'] = $validated['raised_amount'] ?? 0;

        $campaign->update($validated);

        return redirect()
            ->route('campaigns.index')
            ->with('success', 'Campaign updated successfully.');
    }

    /**
     * Remove the specified campaign.
     */
    public function destroy(DonationCampaign $campaign)
    {
        if ($campaign->image) {
            Storage::disk('public')->delete($campaign->image);
        }

        $campaign->delete();

        return redirect()
            ->route('campaigns.index')
            ->with('success', 'Campaign deleted successfully.');
    }

    /**
     * Toggle campaign active status.
     */
    public function toggleStatus(DonationCampaign $campaign)
    {
        $campaign->update(['is_active' => !$campaign->is_active]);

        return back()->with('success', 'Campaign status updated.');
    }

    /**
     * Toggle campaign featured status.
     */
    public function toggleFeatured(DonationCampaign $campaign)
    {
        $campaign->update(['is_featured' => !$campaign->is_featured]);

        return back()->with('success', 'Campaign featured status updated.');
    }
}