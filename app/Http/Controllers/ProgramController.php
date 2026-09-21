<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProgramController extends Controller
{

    public function homeindex() {
       $programs = Program::active()
            ->ordered()
            ->get()
            ->map(fn (Program $p) => [
                'id'                => $p->id,
                'title'             => $p->title,
                'slug'              => $p->slug,
                'short_description' => $p->short_description,
                'full_description'  => $p->full_description,
                'icon'              => $p->icon,
                'image'             => $p->image_url,
            ]);

        return Inertia::render('Programs', [
            'programs' => $programs,
        ]);
    }
    /**
     * Display a listing of programs.
     */
    public function index(Request $request)
    {
        $query = Program::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sort
        $sort = $request->input('sort', 'order');
        match ($sort) {
            'title' => $query->orderBy('title'),
            'newest' => $query->latest(),
            default => $query->orderBy('order')->orderBy('title'),
        };

        $programs = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => Program::count(),
            'active' => Program::where('is_active', true)->count(),
            'inactive' => Program::where('is_active', false)->count(),
        ];

        return Inertia::render('Dashboard/Programs/Index', [
            'programs' => $programs,
            'stats' => $stats,
            'filters' => [
                'search' => $request->input('search', ''),
                'status' => $request->input('status', 'all'),
                'sort' => $request->input('sort', 'order'),
            ],
        ]);
    }

    /**
     * Show the form for creating a new program.
     */
    public function create()
    {
        return Inertia::render('Admin/Programs/Create');
    }

    /**
     * Store a single newly created program.
     */
    public function store(Request $request)
    {
        // Validation rules inline
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:programs,slug'],
            'short_description' => ['required', 'string', 'max:500'],
            'full_description' => ['nullable', 'string'],
            'icon' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('programs', 'public');
        }

        // Defaults
        $validated['order'] = $validated['order'] ?? (Program::max('order') + 1);
        $validated['is_active'] = $request->boolean('is_active', true);

        // Store single program
        Program::create($validated);

        return redirect()
            ->route('programs.index')
            ->with('success', 'Program created successfully.');
    }

    /**
     * Display the specified program.
     */
    public function show(Program $program)
    {
        return Inertia::render('Admin/Programs/Show', [
            'program' => $program,
        ]);
    }

    /**
     * Show the form for editing the specified program.
     */
    public function edit(Program $program)
    {
        return Inertia::render('Admin/Programs/Edit', [
            'program' => $program,
        ]);
    }

    /**
     * Update the specified program.
     */
    public function update(Request $request, Program $program)
    {
        // Validation rules inline (ignore current slug)
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('programs', 'slug')->ignore($program->id)],
            'short_description' => ['required', 'string', 'max:500'],
            'full_description' => ['nullable', 'string'],
            'icon' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($program->image) {
                Storage::disk('public')->delete($program->image);
            }
            $validated['image'] = $request->file('image')->store('programs', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $program->update($validated);

        return redirect()
            ->route('programs.index')
            ->with('success', 'Program updated successfully.');
    }

    /**
     * Remove the specified program.
     */
    public function destroy(Program $program)
    {
        if ($program->image) {
            Storage::disk('public')->delete($program->image);
        }

        $program->delete();

        return redirect()
            ->route('programs.index')
            ->with('success', 'Program deleted successfully.');
    }

    /**
     * Toggle program active status.
     */
    public function toggleStatus(Program $program)
    {
        $program->update(['is_active' => !$program->is_active]);

        return back()->with('success', 'Program status updated.');
    }
}
