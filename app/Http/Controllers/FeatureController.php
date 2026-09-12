<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
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

        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        Feature::create($validated);

        return back()->with([
            'success' => 'Feature created successfully!',
            'initialFeatures' => Feature::orderBy('order', 'asc')->get()
        ]);


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
         $feature = Feature::findOrFail($id);

            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'icon' => 'sometimes|required|string|max:100',
                'color' => 'nullable|string|max:20',
                'order' => 'nullable|integer|min:0',
                'is_active' => 'nullable|boolean'
            ]);

            $feature->update($validated);

             return back()->with([
            'success' => 'Feature created successfully!',
            'initialFeatures' => Feature::orderBy('order', 'asc')->get()
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fetuares = Feature::findOrFail($id);
        
        
        $fetuares->delete();

        return redirect()-> back()-> with('success', 'Notice deleted successfully');
    }
}
