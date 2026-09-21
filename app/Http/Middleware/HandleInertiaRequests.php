<?php

namespace App\Http\Middleware;

use App\Models\Event;
use App\Models\Program;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),

            // ─── Flash messages ───
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error'   => fn () => $request->session()->get('error'),
                'message' => fn () => $request->session()->get('message'),
            ],

            // ─── Auth user ───
            'auth' => [
                'user' => $request->user(),
            ],

            // ─── Footer: Programs ───
            'footerPrograms' => fn () => Program::query()
                ->where('is_active', true)
                ->orderBy('order')
                ->orderBy('id')
                ->take(8)
                ->get()
                ->map(fn (Program $p) => [
                    'id'    => $p->id,
                    'title' => $p->title,
                    'slug'  => $p->slug,
                    'url'   => '/programs#' . $p->slug,
                ])
                ->toArray(),

            // ─── Footer: Social Links ───
            'footerSocialLinks' => fn () => SocialLink::query()
                ->where('is_active', true)
                ->orderBy('order')
                ->orderBy('id')
                ->get()
                ->map(fn (SocialLink $s) => [
                    'id'       => $s->id,
                    'platform' => $s->platform,
                    'url'      => $s->url,
                    'icon'     => $s->icon,
                ])
                ->toArray(),

            // ─── Footer: Upcoming Events ───
            'footerUpcomingEvents' => fn () => Event::query()
                ->where('is_active', true)
                ->where('starts_at', '>=', now())
                ->orderBy('starts_at')
                ->take(3)
                ->get()
                ->map(fn (Event $e) => [
                    'id'    => $e->id,
                    'title' => $e->title,
                    'slug'  => $e->slug,
                    'month' => strtoupper($e->starts_at?->format('M') ?? ''),
                    'day'   => $e->starts_at?->format('d') ?? '',
                    'url'   => '/event/' . $e->slug,
                ])
                ->toArray(),
        ];
    }
}