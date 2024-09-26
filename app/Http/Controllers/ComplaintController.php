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

    // Store the submitted complaint
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
        ]);

        return redirect()->route('complaints.index')->with('success', 'Complaint submitted successfully.');
    }

    // Display all complaints for the landlord/tenant
    public function index()
    {
        $complaints = Complaint::all();
        return view('complaints.index', compact('complaints'));
    }
}
