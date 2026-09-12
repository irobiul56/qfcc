<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notice = Notice::with('category')->get();
        $category = Category::all();
        return Inertia::render('Dashboard/Notice/Index',[
            'notice'  => $notice,   
            'category'  => $category   
        ]);
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
         $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        Notice::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            
        ]);

        return redirect()->route('notices.index')->with('success', 'Notice created successfully');

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
    public function update(Request $request, $id)
    {
        $notice = Notice::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',

        ]);

        $updateData = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
        ];

        $notice->update($updateData);

        return redirect()->back()->with('success', 'Notice updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $notice = Notice::findOrFail($id);
        
        
        $notice->delete();

        return redirect()-> back()-> with('success', 'Notice deleted successfully');
    }
}
