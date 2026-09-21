<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Donation;
use App\Models\DonationCampaign;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Membership;
use App\Models\NewsletterSubscriber;
use App\Models\Transaction;
use App\Models\Volunteer;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard/Dashboard', [
            'stats'             => $this->getStats(),
            'donationChart'     => $this->getDonationChart(),
            'donationTypes'     => $this->getDonationTypes(),
            'recentDonations'   => $this->getRecentDonations(),
            'upcomingEvents'    => $this->getUpcomingEvents(),
            'recentVolunteers'  => $this->getRecentVolunteers(),
            'topDonors'         => $this->getTopDonors(),
            'recentMessages'    => $this->getRecentMessages(),
        ]);
    }

    /* ═══════════════════════════════════════════════════════
       STATS — top summary cards
       ═══════════════════════════════════════════════════════ */
    private function getStats(): array
    {
        // Donations
        $totalDonations = (float) Donation::completed()->sum('amount');
        $donationsThisMonth = (float) Donation::completed()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        // Volunteers
        $totalVolunteers = Volunteer::count();
        $pendingVolunteers = Volunteer::where('status', 'pending')->count();

        // Memberships
        $totalMembers = Membership::count();
        $activeMembers = Membership::where('status', 'approved')->count();

        // Events
        $totalEvents = Event::count();
        $upcomingEvents = Event::active()->upcoming()->count();

        // Programs — if you have a Program model, replace accordingly
        $totalPrograms = method_exists(\App\Models\Program::class, 'count')
            ? \App\Models\Program::count()
            : 0;
        $activePrograms = method_exists(\App\Models\Program::class, 'count')
            ? \App\Models\Program::where('is_active', true)->count()
            : 0;

        // Event registrations
        $totalRegistrations = EventRegistration::count();

        // Newsletter
        $newsletterSubscribers = NewsletterSubscriber::where('is_active', true)->count();

        // Messages
        $unreadMessages = ContactMessage::where('is_read', false)->count();

        return [
            'total_donations'        => $totalDonations,
            'donations_this_month'   => $donationsThisMonth,
            'total_volunteers'       => $totalVolunteers,
            'pending_volunteers'     => $pendingVolunteers,
            'total_members'          => $totalMembers,
            'active_members'         => $activeMembers,
            'total_events'           => $totalEvents,
            'upcoming_events'        => $upcomingEvents,
            'total_programs'         => $totalPrograms,
            'active_programs'        => $activePrograms,
            'total_registrations'    => $totalRegistrations,
            'newsletter_subscribers' => $newsletterSubscribers,
            'unread_messages'        => $unreadMessages,
        ];
    }

    /* ═══════════════════════════════════════════════════════
       DONATION CHART — last 12 months
       ═══════════════════════════════════════════════════════ */
    private function getDonationChart(): array
    {
        $start = now()->subMonths(11)->startOfMonth();

        $rows = Donation::completed()
            ->where('created_at', '>=', $start)
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as ym"),
                DB::raw("SUM(amount) as total")
            )
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        // Build 12 months (fill missing with 0)
        $chart = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i)->startOfMonth();
            $ym = $date->format('Y-m');
            $chart[] = [
                'month' => $ym,
                'total' => (float) ($rows->get($ym)->total ?? 0),
            ];
        }

        return $chart;
    }

    /* ═══════════════════════════════════════════════════════
       DONATION TYPES — one_time vs monthly
       ═══════════════════════════════════════════════════════ */
    private function getDonationTypes(): array
    {
        $rows = Donation::completed()
            ->select(
                'type',
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('type')
            ->get()
            ->keyBy('type');

        return [
            [
                'type'  => 'one_time',
                'total' => (float) ($rows->get('one_time')->total ?? 0),
                'count' => (int) ($rows->get('one_time')->count ?? 0),
            ],
            [
                'type'  => 'monthly',
                'total' => (float) ($rows->get('monthly')->total ?? 0),
                'count' => (int) ($rows->get('monthly')->count ?? 0),
            ],
        ];
    }

    /* ═══════════════════════════════════════════════════════
       RECENT DONATIONS
       ═══════════════════════════════════════════════════════ */
    private function getRecentDonations(): array
    {
        return Donation::completed()
            ->latest()
            ->take(5)
            ->get()
            ->map(fn (Donation $d) => [
                'id'         => $d->id,
                'donor_name' => $d->is_anonymous ? 'Anonymous' : ($d->donor_name ?: 'Anonymous'),
                'amount'     => (float) $d->amount,
                'type'       => $d->type,
                'created_at' => $d->created_at->toIso8601String(),
            ])
            ->toArray();
    }

    /* ═══════════════════════════════════════════════════════
       UPCOMING EVENTS
       ═══════════════════════════════════════════════════════ */
    private function getUpcomingEvents(): array
    {
        return Event::active()
            ->upcoming()
            ->take(4)
            ->get()
            ->map(fn (Event $e) => [
                'id'        => $e->id,
                'title'     => $e->title,
                'starts_at' => optional($e->starts_at)->toIso8601String(),
                'location'  => $e->location,
                'image'     => $e->image_url,
            ])
            ->toArray();
    }

    /* ═══════════════════════════════════════════════════════
       RECENT VOLUNTEERS
       ═══════════════════════════════════════════════════════ */
    private function getRecentVolunteers(): array
    {
        return Volunteer::latest()
            ->take(5)
            ->get()
            ->map(fn (Volunteer $v) => [
                'id'        => $v->id,
                'full_name' => $v->full_name,
                'email'     => $v->email,
                'status'    => $v->status,
            ])
            ->toArray();
    }

    /* ═══════════════════════════════════════════════════════
       TOP DONORS
       ═══════════════════════════════════════════════════════ */
    private function getTopDonors(): array
    {
        return Donation::completed()
            ->select(
                'email',
                DB::raw('MAX(donor_name) as donor_name'),
                DB::raw('SUM(amount) as total_donated')
            )
            ->groupBy('email')
            ->orderByDesc('total_donated')
            ->take(5)
            ->get()
            ->map(fn ($d) => [
                'name'           => $d->donor_name ?: 'Anonymous',
                'email'          => $d->email,
                'total_donated'  => (float) $d->total_donated,
            ])
            ->toArray();
    }

    /* ═══════════════════════════════════════════════════════
       RECENT MESSAGES
       ═══════════════════════════════════════════════════════ */
    private function getRecentMessages(): array
    {
        return ContactMessage::latest()
            ->take(5)
            ->get()
            ->map(fn (ContactMessage $m) => [
                'id'         => $m->id,
                'full_name'  => $m->full_name,
                'subject'    => $m->subject ?: '(No subject)',
                'is_read'    => (bool) $m->is_read,
                'created_at' => $m->created_at->toIso8601String(),
            ])
            ->toArray();
    }
}