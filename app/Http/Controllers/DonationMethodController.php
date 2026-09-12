<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationMethod;
use Illuminate\Http\Request;

class DonationMethodController extends Controller
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
     
        $donation = Donation::first(); // or however you get the donation
    
    // Or if you're still passing donation_id in the request:
    $validated = $request->validate([
        'type' => 'required|in:bank,mobile',
        'title' => 'required|string|max:255',
        'bank_name' => 'required_if:type,bank|nullable|string|max:255',
        'branch' => 'required_if:type,bank|nullable|string|max:255',
        'routing_number' => 'required_if:type,bank|nullable|string|max:50',
        'account_name' => 'required_if:type,bank|nullable|string|max:255',
        'account_no' => 'required_if:type,bank|nullable|string|max:50',
        'platform' => 'required_if:type,mobile|nullable|string|max:50',
        'platform_name' => 'required_if:type,mobile|nullable|string|max:255',
        'merchant_type' => 'required_if:type,mobile|nullable|string|max:255',
        'number' => 'required_if:type,mobile|nullable|string|max:50',
        'order' => 'nullable|integer',
    ]);
    
    // Associate with donation if needed
    if ($donation) {
        $validated['donation_id'] = $donation->id;
    }

    // Handle platform name for mobile banking
    if ($request->type === 'mobile') {
        if ($request->platform !== 'other') {
            // Set platform_name based on platform
            $platformNames = [
                'bkash' => 'bKash',
                'nogod' => 'Nagad',
                'rocket' => 'Rocket',
            ];
            $validated['platform_name'] = $platformNames[$request->platform] ?? ucfirst($request->platform);
        }
    }
    
    // Create the donation method
    $donationMethod = DonationMethod::create($validated);
    
     return back()->with('success', 'Donation method create successfully!');

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
   public function updateMethod(Request $request, DonationMethod $donationMethod)
    {

        $validated = $request->validate([
            'type' => 'required|in:bank,mobile',
            'title' => 'required|string|max:255',
            'bank_name' => 'nullable|required_if:type,bank|string|max:255',
            'branch' => 'nullable|required_if:type,bank|string|max:255',
            'routing_number' => 'nullable|required_if:type,bank|string|max:255',
            'account_name' => 'nullable|required_if:type,bank|string|max:255',
            'account_no' => 'nullable|required_if:type,bank|string|max:255',
            'platform' => 'nullable|required_if:type,mobile|string|max:255',
            'platform_name' => 'nullable|required_if:type,mobile|string|max:255',
            'merchant_type' => 'nullable|required_if:type,mobile|string|max:255',
            'number' => 'nullable|required_if:type,mobile|string|max:255',
            'order' => 'nullable|integer'
        ]);

        $donationMethod->update($validated);

        return back()->with('success', 'Donation method updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyMethod(string $id)
    {
         $donation = DonationMethod::findOrFail($id);
        
        
        $donation->delete();

        return redirect()-> back()-> with('success', 'Donation method deleted successfully');
    }
}
