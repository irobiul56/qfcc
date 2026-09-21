<?php

namespace App\Http\Controllers;

use App\Models\SocialLink;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SocialLinkController extends Controller
{
    /**
     * Admin dashboard — list all social links.
     */
    public function index(Request $request): Response
    {
        $query = SocialLink::query()->ordered();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('platform', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $stats = [
            'total'    => SocialLink::count(),
            'active'   => SocialLink::where('is_active', true)->count(),
            'inactive' => SocialLink::where('is_active', false)->count(),
        ];

        return Inertia::render('Dashboard/SocialLinks/Index', [
            'links'   => $query->paginate(20)->withQueryString(),
            'stats'   => $stats,
            'filters' => [
                'search'    => $request->input('search', ''),
                'is_active' => $request->input('is_active', ''),
            ],
        ]);
    }

    /**
     * Store a new social link.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform'  => ['required', 'string', 'max:50'],
            'url'       => ['required', 'url', 'max:500'],
            'icon'      => ['required', 'string', 'max:50'],
            'order'     => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['boolean'],
        ]);

        $validated['order']     = $validated['order'] ?? 0;
        $validated['is_active'] = $validated['is_active'] ?? true;

        SocialLink::create($validated);

        return back()->with('success', 'Social link created successfully.');
    }

    /**
     * Update an existing social link.
     */
    public function update(Request $request, SocialLink $socialLink)
    {
        $validated = $request->validate([
            'platform'  => ['required', 'string', 'max:50'],
            'url'       => ['required', 'url', 'max:500'],
            'icon'      => ['required', 'string', 'max:50'],
            'order'     => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['boolean'],
        ]);

        $validated['order']     = $validated['order'] ?? 0;
        $validated['is_active'] = $validated['is_active'] ?? true;

        $socialLink->update($validated);

        return back()->with('success', 'Social link updated successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(SocialLink $socialLink)
    {
        $socialLink->update([
            'is_active' => !$socialLink->is_active,
        ]);

        return back()->with('success', 'Status updated.');
    }

    /**
     * Delete a social link.
     */
    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();

        return back()->with('success', 'Social link deleted.');
    }
}