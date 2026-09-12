<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $donation = Donation::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',

        ]);

        $updateData = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
        ];

        $donation->update($updateData);

        return redirect()->back()->with('success', 'Donation updated successfully!');
    }

    //updateImage

    public function updateImage(Request $request, string $id)
    {

         $donation = Donation::findOrFail($id);

         $validated = $request->validate([
            'main_image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('main_image')) {
            // Delete old image
            if ($donation->main_image) {
                Storage::delete('public/' . $donation->main_image);
            }

            // Store new image
            $path = $request->file('main_image')->store('images/donation', 'public');
            $validated['main_image'] = $path;
        }

        $donation->update($validated);

        return back()->with('success', 'Donation section updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
