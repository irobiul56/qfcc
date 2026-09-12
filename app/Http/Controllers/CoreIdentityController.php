<?php

namespace App\Http\Controllers;

use App\Models\Coreidentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoreIdentityController extends Controller
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
    // Store new core identity
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:background,vision,mission',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('core-identities', 'public');
            $validated['image'] = $path;
        }

        Coreidentity::create($validated);

        return redirect()->back()->with('success', 'Core Identity created successfully.');
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
     // Update core identity
    public function update(Request $request, $id)
{
    // Find the model manually
    $coreIdentity = Coreidentity::findOrFail($id);
    
    $validated = $request->validate([
        'type' => 'required|in:background,vision,mission',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'content' => 'nullable|string',
        'image' => 'nullable|image|max:2048'
    ]);

    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($coreIdentity->image) {
            Storage::disk('public')->delete($coreIdentity->image);
        }
        
        $path = $request->file('image')->store('core-identities', 'public');
        $validated['image'] = $path;
    } else {
        unset($validated['image']);
    }

    $coreIdentity->update($validated);

    return redirect()->back()->with('success', 'Core Identity updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(CoreIdentity $coreIdentity)
    {
        // Delete image if exists
        if ($coreIdentity->image) {
            Storage::disk('public')->delete($coreIdentity->image);
        }
        
        $coreIdentity->delete();
        
        return redirect()->back()->with('success', 'Core Identity deleted successfully.');
    }
}