<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactMessageController extends Controller
{
    /**
     * Admin list view.
     */
    public function index(Request $request): Response
    {
        $query = ContactMessage::query()->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            if ($status === 'unread') {
                $query->where('is_read', false);
            } elseif ($status === 'read') {
                $query->where('is_read', true);
            }
        }

        return Inertia::render('Dashboard/ContactMessages/Index', [
            'messages' => $query->paginate(20)->withQueryString(),
            'stats' => [
                'total'  => ContactMessage::count(),
                'unread' => ContactMessage::where('is_read', false)->count(),
                'read'   => ContactMessage::where('is_read', true)->count(),
                'today'  => ContactMessage::whereDate('created_at', today())->count(),
            ],
            'filters' => [
                'search' => $request->input('search', ''),
                'status' => $request->input('status', ''),
            ],
        ]);
    }

    /**
     * Store a new contact message (public form).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255'],
            'phone'     => ['nullable', 'string', 'max:30'],
            'subject'   => ['nullable', 'string', 'max:255'],
            'message'   => ['required', 'string', 'max:5000'],
        ]);

        $contact = ContactMessage::create($validated);

        if ($request->wantsJson() && !$request->header('X-Inertia')) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you — we\'ll get back to you soon.',
                'id'      => $contact->id,
            ]);
        }

        return back()->with('success', 'Thank you! Your message has been sent.');
    }

    /**
     * Mark a message as read.
     */
    public function markRead(ContactMessage $message)
    {
        $message->markAsRead();
        return back()->with('success', 'Marked as read.');
    }

    /**
     * Mark a message as unread.
     */
    public function markUnread(ContactMessage $message)
    {
        $message->markAsUnread();
        return back()->with('success', 'Marked as unread.');
    }

    /**
     * Delete a message.
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return back()->with('success', 'Message deleted.');
    }
}