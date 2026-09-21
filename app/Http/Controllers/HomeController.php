<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Program;
use App\Models\VisionMission;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        // ─── Vision / Mission ───
        $vision  = VisionMission::active()->ordered()->where('type', 'vision')->first();
        $mission = VisionMission::active()->ordered()->where('type', 'mission')->first();

        // ─── Programs ───
        $programs = Program::active()
            ->ordered()
            ->get()
            ->map(fn (Program $p) => [
                'id'          => $p->id,
                'title'       => $p->title,
                'description' => $p->description,
                'icon'        => $p->icon,
                'link'        => $p->link ?: '#',
            ]);

        // ─── Upcoming Events (next 3) ───
        $upcomingEvents = Event::active()
            ->upcoming()
            ->take(3)
            ->get()
            ->map(fn (Event $e) => [
                'id'       => $e->id,
                'month'    => strtoupper($e->starts_at?->format('M') ?? ''),
                'day'      => $e->starts_at?->format('d') ?? '',
                'title'    => $e->title,
                'dateTime' => $e->starts_at?->format('D, F j, Y · g:i A') ?? '',
                'location' => $e->location ?? '',
                'image'    => $e->image_url,
                'slug'     => $e->slug,
            ]);

        return Inertia::render('Home', [
            'vision'         => $vision ? [
                'heading' => $vision->heading,
                'content' => $vision->content,
                'icon'    => $vision->icon,
            ] : null,
            'mission'        => $mission ? [
                'heading' => $mission->heading,
                'content' => $mission->content,
                'icon'    => $mission->icon,
            ] : null,
            'programs'       => $programs,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}