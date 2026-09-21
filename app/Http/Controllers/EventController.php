<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index(Request $request)
    {
        $query = Event::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            match ($status) {
                'active' => $query->where('is_active', true),
                'inactive' => $query->where('is_active', false),
                'featured' => $query->where('is_featured', true),
                'upcoming' => $query->where('starts_at', '>=', now()),
                'past' => $query->where('starts_at', '<', now()),
                default => null,
            };
        }

        // Sort
        $sort = $request->input('sort', 'upcoming');
        match ($sort) {
            'title' => $query->orderBy('title'),
            'newest' => $query->latest(),
            'oldest' => $query->oldest(),
            default => $query->orderBy('starts_at', 'desc'),
        };

        $events = $query->paginate(10)->withQueryString();

        // Stats
        $stats = [
            'total' => Event::count(),
            'active' => Event::where('is_active', true)->count(),
            'upcoming' => Event::where('starts_at', '>=', now())->count(),
            'featured' => Event::where('is_featured', true)->count(),
        ];

        return Inertia::render('Dashboard/Events/Index', [
            'events' => $events,
            'stats' => $stats,
            'filters' => [
                'search' => $request->input('search', ''),
                'status' => $request->input('status', 'all'),
                'sort' => $request->input('sort', 'upcoming'),
            ],
        ]);
    }

    //Show the form for creating a new event
      public function create()
{
    // Featured event
    $featured = Event::active()
        ->upcoming()
        ->featured()
        ->first()
        ?? Event::active()->upcoming()->first();

    // Upcoming events (excluding featured)
    $upcoming = Event::active()
        ->upcoming()
        ->when($featured, fn ($q) => $q->where('id', '!=', $featured->id))
        ->withCount(['registrations as confirmed_count' => function ($q) {
            $q->where('status', 'confirmed');
        }])
        ->get()
        ->map(fn (Event $event) => [
            'id'          => $event->id,
            'slug'        => $event->slug,
            'title'       => $event->title,
            'description' => $event->description,
            'image'       => $event->image_url,
            'month'       => $event->month,
            'day'         => $event->day,
            'time'        => $event->time_label,
            'location'    => $event->location,
            'event_type'  => $event->event_type,
            'category'    => $event->category_label,
            'capacity'    => $event->capacity,
            'is_full'     => $event->isFull(),
            'spots_left'  => $event->spotsLeft(),
        ]);

    // Filter tabs
    $categories = Event::active()
        ->upcoming()
        ->select('event_type')
        ->distinct()
        ->pluck('event_type')
        ->map(fn ($type) => [
            'value' => $type,
            'label' => match ($type) {
                'iftar'      => 'COMMUNITY',
                'workshop'   => 'YOUTH',
                'seminar'    => 'WELLNESS',
                'fundraiser' => 'FUNDRAISING',
                'outreach'   => 'OUTREACH',
                default      => strtoupper($type),
            },
        ])
        ->values();

    // Featured event
    $featuredData = $featured ? [
        'id'          => $featured->id,
        'slug'        => $featured->slug,
        'title'       => $featured->title,
        'description' => $featured->description,
        'image'       => $featured->image_url,
        'month'       => $featured->month,
        'day'         => $featured->day,
        'date_label'  => $featured->date_label,
        'time'        => $featured->starts_at?->format('g:i A'),
        'location'    => $featured->location,
        'address'     => $featured->address,
        'event_type'  => $featured->event_type,
        'category'    => $featured->category_label,
        'capacity'    => $featured->capacity,
        'is_full'     => $featured->isFull(),
        'spots_left'  => $featured->spotsLeft(),
    ] : null;

    return Inertia::render('Event', [
        'featured'   => $featuredData,
        'events'     => $upcoming,
        'categories' => $categories,
    ]);
}


public function show(Event $event)
{
    // Only published/active events
    abort_unless($event->is_active, 404);

    // Load related events (same type, upcoming, excluding current)
    $related = Event::active()
        ->upcoming()
        ->where('id', '!=', $event->id)
        ->when($event->event_type, fn ($q) => $q->where('event_type', $event->event_type))
        ->limit(3)
        ->get()
        ->map(fn (Event $e) => [
            'id'          => $e->id,
            'slug'        => $e->slug,
            'title'       => $e->title,
            'description' => $e->description,
            'image'       => $e->image_url,
            'month'       => $e->month,
            'day'         => $e->day,
            'time'        => $e->time_label,
            'location'    => $e->location,
            'event_type'  => $e->event_type,
            'category'    => $e->category_label,
            'is_full'     => $e->isFull(),
            'spots_left'  => $e->spotsLeft(),
        ]);

    // If not enough related events, fill with any upcoming
    if ($related->count() < 3) {
        $fill = Event::active()
            ->upcoming()
            ->where('id', '!=', $event->id)
            ->whereNotIn('id', $related->pluck('id'))
            ->limit(3 - $related->count())
            ->get()
            ->map(fn (Event $e) => [
                'id'          => $e->id,
                'slug'        => $e->slug,
                'title'       => $e->title,
                'description' => $e->description,
                'image'       => $e->image_url,
                'month'       => $e->month,
                'day'         => $e->day,
                'time'        => $e->time_label,
                'location'    => $e->location,
                'event_type'  => $e->event_type,
                'category'    => $e->category_label,
                'is_full'     => $e->isFull(),
                'spots_left'  => $e->spotsLeft(),
            ]);

        $related = $related->concat($fill);
    }

    return Inertia::render('EventsShow', [
        'event' => [
            'id'            => $event->id,
            'slug'          => $event->slug,
            'title'         => $event->title,
            'description'   => $event->description,
            'image'         => $event->image_url,
            'month'         => $event->month,
            'day'           => $event->day,
            'date_label'    => $event->date_label,
            'date_full'     => $event->starts_at?->format('l, F j, Y'),
            'time'          => $event->starts_at?->format('g:i A'),
            'end_time'      => $event->ends_at?->format('g:i A'),
            'time_range'    => $event->starts_at?->format('g:i A') . ($event->ends_at ? ' – ' . $event->ends_at->format('g:i A') : ''),
            'location'      => $event->location,
            'address'       => $event->address,
            'event_type'    => $event->event_type,
            'category'      => $event->category_label,
            'capacity'      => $event->capacity,
            'is_full'       => $event->isFull(),
            'spots_left'    => $event->spotsLeft(),
            'registered_count' => $event->confirmedGuestsCount(),
        ],
        'relatedEvents' => $related,
    ]);
}
    
    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:events,slug'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'location' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'event_type' => ['required', 'string', 'max:50'],
            'capacity' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['is_active'] = $request->boolean('is_active', true);

        Event::create($validated);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Update the specified event.
     */
   public function update(Request $request, Event $event)
{
    $validated = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'slug' => ['nullable', 'string', 'max:255', Rule::unique('events', 'slug')->ignore($event->id)],
        'description' => ['nullable', 'string'],
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        'starts_at' => ['required', 'date'],
        'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        'location' => ['nullable', 'string', 'max:255'],
        'address' => ['nullable', 'string', 'max:500'],
        'event_type' => ['required', 'string', 'max:50'],
        'capacity' => ['nullable', 'integer', 'min:0'],
        'is_featured' => ['boolean'],
        'is_active' => ['boolean'],
        'remove_image' => ['nullable', 'boolean'],   // NEW
    ]);

    if (empty($validated['slug'])) {
        $validated['slug'] = Str::slug($validated['title']);
    }

    // Handle image
    if ($request->hasFile('image')) {
        // New image uploaded — delete old and store new
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        $validated['image'] = $request->file('image')->store('events', 'public');
    } elseif ($request->boolean('remove_image')) {
        // User explicitly removed the image
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        $validated['image'] = null;
    }

    // Remove helper key from validated data
    unset($validated['remove_image']);

    $validated['is_featured'] = $request->boolean('is_featured', false);
    $validated['is_active'] = $request->boolean('is_active', true);

    $event->update($validated);

    return redirect()
        ->route('events.index')
        ->with('success', 'Event updated successfully.');
}

    /**
     * Remove the specified event.
     */
    public function destroy(Event $event)
    {
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Toggle event active status.
     */
    public function toggleStatus(Event $event)
    {
        $event->update(['is_active' => !$event->is_active]);

        return back()->with('success', 'Event status updated.');
    }

    /**
     * Toggle event featured status.
     */
    public function toggleFeatured(Event $event)
    {
        $event->update(['is_featured' => !$event->is_featured]);

        return back()->with('success', 'Event featured status updated.');
    }
}