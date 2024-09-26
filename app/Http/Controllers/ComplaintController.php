<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    // Display the form to submit a complaint
    public function create()
    {
        return view('complaints.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:255',
            'block' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'telephone_number' => 'required|string|max:15',
            'description' => 'required|string',
        ]);
    
        Complaint::create([
            'tenant_id' => Auth::id(),
            'room_number' => $request->room_number,
            'block' => $request->block,
            'location' => $request->location,
            'telephone_number' => $request->telephone_number,
            'description' => $request->description,
            'complaint_code' => rand(100000, 999999), // Generating a 6-character random string
        ]);
    
        return redirect()->route('complaints.index')->with('success', 'Complaint submitted successfully.');
    }
    

    // Display all complaints for the landlord/tenant
    public function index()
    {
        $complaints = Complaint::all();
        return view('complaints.index', compact('complaints'));
    }

    public function resolve($complaintCode)
{
    // Find the complaint by its complaint code
    $complaint = Complaint::where('complaint_code', $complaintCode)->first();

    // Check if complaint exists
    if (!$complaint) {
        return redirect()->back()->with('error', 'Complaint not found.');
    }

    // Check if the complaint is already resolved
    if ($complaint->status === 'resolved') {
        return redirect()->back()->with('info', 'This complaint is already resolved.');
    }

    try {
        // Mark the complaint as resolved
        $complaint->status = 'resolved';
        $complaint->resolved_at = now(); // Assuming you have a field for resolved time
        $complaint->save();

        return redirect()->route('complaints.index')->with('success', 'Complaint resolved successfully.');

    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error("Error resolving complaint: " . $e->getMessage());

        return redirect()->back()->with('error', 'There was an issue resolving the complaint.');
    }
}

// Display all complaints for the rental manager
public function allComplaints()
{
    $complaints = Complaint::all(); // Fetch all complaints
    return view('complaints.all', compact('complaints')); // Return the view with complaints
}


}
