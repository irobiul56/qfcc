<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blog = Blog::with('category')->get();
        $category = Category::all();
        return Inertia::render('Dashboard/Blog/Index',[
            'blog'  => $blog,   
            'category'  => $category   
        ]);
    }


public function BlogPost(Request $request)
{
    $perPage = 6; // Number of posts per page
    
    $blog = Blog::with('category')
                ->latest()
                ->paginate($perPage);
    
    return Inertia::render('BlogPost', [
        'blog' => $blog,
        // Let Inertia handle pagination data automatically
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all();
        return inertia::render('Dashboard/Blog/AddForm', [
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
            $imagePath = $request->file('image')->store('blog', 'public');
        }

        Blog::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('blogpost.index')->with('success', 'Activity created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return Inertia::render('Blog/Show', [
            'blog' => $blog,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        $categories = Category::all();
        
        return inertia('Dashboard/Blog/Edit', [
            'blog' => $blog,
            'category' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

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
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            
            // Store new image
            $updateData['image'] = $request->file('image')->store('blog', 'public');
        }

        $blog->update($updateData);

        return redirect()->route('blogpost.index')->with('success', 'Blog updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        
        // Delete associated image
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }
        
        $blog->delete();

        return redirect()->route('blogpost.index')->with('success', 'Blog deleted successfully');
    }
}