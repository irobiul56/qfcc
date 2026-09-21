<?php

namespace App\Http\Controllers;

use App\Models\VisionMission;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class VisionMissionController extends Controller
{
    /**
     * Admin dashboard — list all visions & missions.
     */
    public function index(Request $request): Response
    {
        $query = VisionMission::query()->ordered();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('heading', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // Filter by active status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Stats
        $stats = [
            'total'    => VisionMission::count(),
            'visions'  => VisionMission::where('type', 'vision')->count(),
            'missions' => VisionMission::where('type', 'mission')->count(),
            'inactive' => VisionMission::where('is_active', false)->count(),
        ];

        return Inertia::render('Dashboard/VisionsMissions/Index', [
            'items'   => $query->paginate(20)->withQueryString(),
            'stats'   => $stats,
            'filters' => [
                'search'    => $request->input('search', ''),
                'type'      => $request->input('type', ''),
                'is_active' => $request->input('is_active', ''),
            ],
        ]);
    }


     public function about(): Response
    {
        $vision  = VisionMission::active()->where('type', 'vision')->ordered()->first();
        $mission = VisionMission::active()->where('type', 'mission')->ordered()->first();

        return Inertia::render('About', [
            'vision' => $vision ? [
                'id'      => $vision->id,
                'heading' => $vision->heading,
                'content' => $vision->content,
                'icon'    => $vision->icon,
            ] : null,

            'mission' => $mission ? [
                'id'      => $mission->id,
                'heading' => $mission->heading,
                'content' => $mission->content,
                'icon'    => $mission->icon,
            ] : null,
        ]);
    }

    /**
     * Store a new vision / mission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'      => ['required', 'in:vision,mission'],
            'heading'   => ['required', 'string', 'max:255'],
            'content'   => ['required', 'string', 'max:5000'],
            'icon'      => ['required', 'string', 'max:100'],
            'order'     => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['boolean'],
        ]);

        $validated['order']     = $validated['order'] ?? 0;
        $validated['is_active'] = $validated['is_active'] ?? true;

        VisionMission::create($validated);

        return back()->with('success', 'Vision/Mission created successfully.');
    }

    /**
     * Update an existing vision / mission.
     */
    public function update(Request $request, VisionMission $visionMission)
    {
        $validated = $request->validate([
            'type'      => ['required', 'in:vision,mission'],
            'heading'   => ['required', 'string', 'max:255'],
            'content'   => ['required', 'string', 'max:5000'],
            'icon'      => ['required', 'string', 'max:100'],
            'order'     => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['boolean'],
        ]);

        $validated['order']     = $validated['order'] ?? 0;
        $validated['is_active'] = $validated['is_active'] ?? true;

        $visionMission->update($validated);

        return back()->with('success', 'Vision/Mission updated successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(VisionMission $visionMission)
    {
        $visionMission->update([
            'is_active' => !$visionMission->is_active,
        ]);

        return back()->with('success', 'Status updated.');
    }

    /**
     * Delete a vision / mission.
     */
    public function destroy(VisionMission $visionMission)
    {
        $visionMission->delete();

        return back()->with('success', 'Vision/Mission deleted.');
    }
}