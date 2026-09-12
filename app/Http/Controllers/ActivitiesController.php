<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::with('category')->get();
        $category = Category::all();
        return Inertia::render('Dashboard/Activities/Index',[
            'activities'  => $activities,   
            'category'  => $category   
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all();
        return inertia::render('Dashboard/Activities/AddForm', [
            'category'  => $category   
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('activities', 'public');
        }

        Activity::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('activites.index')->with('success', 'Activity created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $activity = Activity::where('slug', $slug)->firstOrFail();
        return Inertia::render('Dashboard/Activities/Show', [
            'activity' => $activity,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $activity = Activity::findOrFail($id);
        $categories = Category::all();
        
        return inertia('Dashboard/Activities/Edit', [
            'activity' => $activity,
            'category' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $updateData = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
        ];

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($activity->image) {
                Storage::disk('public')->delete($activity->image);
            }
            
            // Store new image
            $updateData['image'] = $request->file('image')->store('activities', 'public');
        }

        $activity->update($updateData);

        return redirect()->route('activites.index')->with('success', 'Activity updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        
        // Delete associated image
        if ($activity->image) {
            Storage::disk('public')->delete($activity->image);
        }
        
        $activity->delete();

        return redirect()->route('activites.index')->with('success', 'Activity deleted successfully');
    }
}