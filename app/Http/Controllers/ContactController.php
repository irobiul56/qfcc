<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactlist = Contact::all();
        return Inertia::render('Dashboard/ContactList',[
            'contactlist'  => $contactlist,   
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
      public function contactsubmit(Request $request)
    {


        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Process the contact form data
        // You can send email, save to database, etc.
        
        // Example: Save to database (if you have a Contact model)
        Contact::create($request->all());
        
        // Example: Send email
        // Mail::to('contact@jagoroni.org')->send(new ContactFormSubmitted($request->all()));

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::findOrFail($id);
        
        
        $contact->delete();

        return redirect()-> back()-> with('success', 'Contact deleted successfully');
    }
}
