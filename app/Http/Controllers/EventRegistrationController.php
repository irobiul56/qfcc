<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventRegistrationController extends Controller

{
    public function index(Request $request)
    {
        $query = EventRegistration::with('event:id,title,slug,starts_at')
            ->latest();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by event
        if ($eventId = $request->input('event_id')) {
            $query->where('event_id', $eventId);
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        return Inertia::render('Dashboard/EventRegistrations/Index', [
            'registrations' => $query->paginate(20)->withQueryString(),

            'stats' => [
                'total'     => EventRegistration::count(),
                'pending'   => EventRegistration::where('status', 'pending')->count(),
                'confirmed' => EventRegistration::where('status', 'confirmed')->count(),
                'cancelled' => EventRegistration::where('status', 'cancelled')->count(),
                'guests'    => EventRegistration::where('status', 'confirmed')->sum('guests') 
                                + EventRegistration::where('status', 'confirmed')->count(),
            ],

            'events' => Event::orderBy('title')->get(['id', 'title']),

            'filters' => [
                'search'   => $request->input('search', ''),
                'status'   => $request->input('status', ''),
                'event_id' => $request->input('event_id', ''),
            ],
        ]);
    }

    /**
     * Admin — update status.
     */
    public function updateStatus(Request $request, EventRegistration $registration)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled'],
        ]);

        $registration->update(['status' => $validated['status']]);

        return back()->with('success', 'Status updated.');
    }

    /**
     * Admin — delete registration.
     */
    public function destroy(EventRegistration $registration)
    {
        $registration->delete();
        return back()->with('success', 'Registration removed.');
    }

    /**
     * Admin — export CSV.
     */
    public function export(Request $request)
    {
        $filename = 'event-registrations-' . now()->format('Y-m-d') . '.csv';

        $query = EventRegistration::with('event:id,title');

        if ($eventId = $request->input('event_id')) {
            $query->where('event_id', $eventId);
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'ID', 'Event', 'Full Name', 'Email', 'Phone',
                'Guests', 'Status', 'Notes', 'Registered At',
            ]);

            $query->chunk(500, function ($chunk) use ($handle) {
                foreach ($chunk as $r) {
                    fputcsv($handle, [
                        $r->id,
                        $r->event?->title,
                        $r->full_name,
                        $r->email,
                        $r->phone,
                        $r->guests,
                        $r->status,
                        $r->notes,
                        $r->created_at->toDateTimeString(),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
    public function store(Request $request, Event $event)
    {
        // 1. Reject if the event is already full
        if ($event->isFull()) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, this event is fully booked.',
            ], 422);
        }

        // 2. Validate
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255'],
            'phone'     => ['nullable', 'string', 'max:30'],
            'guests'    => ['nullable', 'integer', 'min:0', 'max:10'],
            'notes'     => ['nullable', 'string', 'max:1000'],
        ]);

        // 3. Reject duplicate registration (unique constraint: event_id + email)
        $exists = EventRegistration::where('event_id', $event->id)
            ->where('email', $validated['email'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this event.',
            ], 422);
        }

        // 4. Create the registration
        try {
            $registration = DB::transaction(function () use ($event, $validated) {
                return EventRegistration::create([
                    'event_id'  => $event->id,
                    'full_name' => $validated['full_name'],
                    'email'     => $validated['email'],
                    'phone'     => $validated['phone'] ?? null,
                    'guests'    => $validated['guests'] ?? 0,
                    'notes'     => $validated['notes'] ?? null,
                    'status'    => 'confirmed',
                ]);
            });
        } catch (\Illuminate\Database\QueryException $e) {
            // In case of a race condition on the unique index
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this event.',
            ], 422);
        }

        // 5. (Optional) Send confirmation email
        // Mail::to($registration->email)->queue(new EventRegistrationConfirmed($registration));

        // 6. Response
        $spotsLeft = $event->fresh()->spotsLeft();

        return response()->json([
            'success'    => true,
            'message'    => 'Registration confirmed! Check your email for details.',
            'registration' => [
                'id'        => $registration->id,
                'full_name' => $registration->full_name,
                'email'     => $registration->email,
                'guests'    => $registration->guests,
                'status'    => $registration->status,
            ],
            'spots_left' => $spotsLeft,
        ]);
    }
}