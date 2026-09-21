<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class VolunteerController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Volunteer/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'      => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'max:255', 'unique:volunteers,email'],
            'phone'          => ['required', 'string', 'max:30'],
            'address'        => ['nullable', 'string', 'max:500'],
            'city'           => ['nullable', 'string', 'max:100'],
            'state'          => ['nullable', 'string', 'max:100'],
            'zip_code'       => ['nullable', 'string', 'max:20'],

            'interests'      => ['nullable', 'array'],
            'interests.*'    => ['string', 'max:100'],

            'availability'   => ['nullable', 'array'],
            'availability.*' => ['string', 'max:50'],

            'skills'         => ['nullable', 'string'],
            'message'        => ['nullable', 'string'],
        ]);

        $volunteer = Volunteer::create($validated);

        return redirect()
            ->route('volunteer.create')
            ->with('success', 'Your volunteer application was submitted successfully.');
    }

    public function index(): Response
    {
        return Inertia::render('Volunteer/Index', [
            'volunteers' => Volunteer::latest()->paginate(20),
        ]);
    }

    public function approve(Volunteer $volunteer)
    {
        $volunteer->update(['status' => 'approved']);
        return back()->with('success', "{$volunteer->full_name}'s application approved.");
    }

    public function reject(Volunteer $volunteer)
    {
        $volunteer->update(['status' => 'rejected']);
        return back()->with('success', "{$volunteer->full_name}'s application rejected.");
    }

    public function destroy(Volunteer $volunteer)
    {
        $volunteer->delete(); // soft delete
        return back()->with('success', 'Volunteer archived.');
    }

    public function restore($id)
    {
        Volunteer::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Volunteer restored.');
    }
}