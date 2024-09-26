<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Property; // Import the Property model

class ReportController extends Controller
{
    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
{
    // Validate input
    $request->validate([
        'issue_type' => 'required|string|max:255',
        'property_id' => 'required|integer|exists:properties,id',
        'description' => 'required|string',
        'urgency' => 'required|in:Low,Medium,High',
    ]);

    // Log the authenticated user and their tenant ID
    \Log::info('Authenticated User:', ['user' => auth()->user()]);

    // Attempt to create the report
    try {
        $report = Report::create([
            'tenant_id' => auth()->user()->id,
            'property_id' => $request->property_id,
            'issue_type' => $request->issue_type,
            'description' => $request->description,
            'urgency' => $request->urgency,
        ]);

        return redirect()->back()->with('success', 'Your report has been submitted.');
    } catch (\Exception $e) {
        \Log::error('Report creation failed: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Failed to submit the report. Please try again.']);
    }
}

}
