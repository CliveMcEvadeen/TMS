<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Tenants; // Include the Tenants model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ComplaintController extends Controller
{
    // Display the form to submit a complaint
    public function create()
    {
        return view('complaints.create');
    }

    // Store the complaint in the database
    public function store(Request $request)
    {
        // Log incoming request data for debugging
        Log::info('Complaint submission request data: ', $request->all());

        $request->validate([
            'room_number' => 'required|string|max:255',
            'block' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'telephone_number' => 'required|string|max:15',
            'description' => 'required|string',
        ]);

        // Get the authenticated user
        $user = Auth::user();
        Log::info('Authenticated user: ', ['user_id' => $user->id]);

        // Find the tenant linked to the authenticated user
        $tenant = Tenants::where('user_id', $user->id)->first();

        // Check if the tenant exists
        if (!$tenant) {
            Log::warning('No tenant information found for user.', ['user_id' => $user->id]);
            return redirect()->back()->with('error', 'No tenant information found for this user.');
        }

        // Create the complaint with the correct tenant ID
        try {
            Complaint::create([
                'tenant_id' => $tenant->id, // Store tenant's ID from the tenants table
                'room_number' => $request->room_number,
                'block' => $request->block,
                'location' => $request->location,
                'telephone_number' => $request->telephone_number,
                'description' => $request->description,
                'complaint_code' => rand(100000, 999999), // Generating a 6-character random number
            ]);

            Log::info('Complaint submitted successfully', ['tenant_id' => $tenant->id]);

            return redirect()->route('complaints.index')->with('success', 'Complaint submitted successfully.');
        } catch (\Exception $e) {
            Log::error("Error creating complaint: " . $e->getMessage(), [
                'tenant_id' => $tenant->id,
                'request_data' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'There was an issue submitting your complaint.');
        }
    }

    // Display all complaints for the logged-in user
    public function index()
    {
        // Find the tenant linked to the authenticated user
        $tenant = Tenants::where('user_id', Auth::id())->first();

        if (!$tenant) {
            Log::warning('No tenant information found for user when fetching complaints.', ['user_id' => Auth::id()]);
            return redirect()->back()->with('error', 'No tenant information found for this user.');
        }

        // Fetch complaints for the authenticated tenant
        $complaints = Complaint::where('tenant_id', $tenant->id)->get();

        Log::info('Fetched complaints for user', ['user_id' => Auth::id(), 'complaints_count' => $complaints->count()]);

        return view('complaints.index', compact('complaints'));
    }

    // Resolve a complaint based on its complaint code
    public function resolve($complaintCode)
    {
        // Find the complaint by its complaint code
        $complaint = Complaint::where('complaint_code', $complaintCode)->first();

        if (!$complaint) {
            Log::warning('Complaint not found', ['complaint_code' => $complaintCode]);
            return redirect()->back()->with('error', 'Complaint not found.');
        }

        if ($complaint->status === 'resolved') {
            Log::info('Complaint already resolved', ['complaint_code' => $complaintCode]);
            return redirect()->back()->with('info', 'This complaint is already resolved.');
        }

        try {
            // Mark the complaint as resolved
            $complaint->status = 'resolved';
            $complaint->resolved_at = now(); 
            $complaint->save();

            Log::info('Complaint resolved successfully', ['complaint_code' => $complaintCode]);

            return redirect()->route('complaints.index')->with('success', 'Complaint resolved successfully.');
        } catch (\Exception $e) {
            Log::error("Error resolving complaint: " . $e->getMessage(), ['complaint_code' => $complaintCode]);

            return redirect()->back()->with('error', 'There was an issue resolving the complaint.');
        }
    }

    // Display all complaints for the rental manager
    public function allComplaints()
    {
        $complaints = Complaint::all();
        Log::info('Fetched all complaints for rental manager', ['complaints_count' => $complaints->count()]);

        return view('complaints.all', compact('complaints'));
    }
}
