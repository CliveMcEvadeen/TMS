<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create()
    {
        // Assuming you have tenant and property data in session or from authentication
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'issue_type' => 'required|string|max:255',
            'description' => 'required|string',
            'urgency' => 'required|in:Low,Medium,High',
        ]);

        Report::create([
            'tenant_id' => auth()->user()->id,  // Assuming the tenant is authenticated
            'property_id' => $request->property_id,  // You can pass the property ID through the form or session
            'issue_type' => $request->issue_type,
            'description' => $request->description,
            'urgency' => $request->urgency,
        ]);

        return redirect()->back()->with('success', 'Your report has been submitted.');
    }
}