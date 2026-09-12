<?php

namespace App\Http\Controllers;
use App\Models\Activity;
use App\Models\Blog;
use App\Models\Coreidentity;
use App\Models\Donation;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home');
    }

public function homeadmin(){
    $slide = Slide::first();
    $coreIdentities = Coreidentity::all();
    $initialFeatures = Feature::orderBy('order', 'asc')->get();
    $donationData = Donation::with('donationMethods')->first();
    
    return Inertia::render('Dashboard/Home/Index', [
        'slide' => $slide,
        'coreIdentities' => $coreIdentities,
        'features' => $initialFeatures,
        'donationData' => $donationData,
    ]);
}

    public function singleactivity($slug)
    {
        $activity = Activity::where('slug', $slug)->firstOrFail();
        return Inertia::render('Dashboard/Activities/Show', [
            'activity' => $activity,
        ]);
    }


 public function update(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:500',
        'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    // Get existing slide or prepare to create new
    $slide = Slide::first();
    
    // Store current image path
    $currentImage = $slide ? $slide->background_image : null;

    // Process the image if uploaded
    if ($request->hasFile('background_image')) {
        // Store new image
        $path = $request->file('background_image')->store('slides', 'public');
        $validated['background_image'] = $path;
        
        // Delete old image if exists
        if ($currentImage && Storage::disk('public')->exists($currentImage)) {
            Storage::disk('public')->delete($currentImage);
        }
    } else {
        // If no new image, keep the existing one
        $validated['background_image'] = $currentImage;
    }

    // Use updateOrCreate to handle both cases
    $slide = Slide::updateOrCreate(
        ['id' => $slide ? $slide->id : 0], // Condition
        $validated // Data to update/create
    );

    return redirect()->back()->with([
        'success' => 'Slide updated successfully!',
        'slide' => $slide
    ]);
}

}