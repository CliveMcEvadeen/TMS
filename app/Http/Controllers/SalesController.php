<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Tenants;
use App\Models\Property;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\SalesFormRequest;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $this->authorize('viewAny_sales', Sales::class);
        
        $sales = Sales::with('property:id,property_name','tenant:id,name','payment')
            ->select('*','sales.id as id')
            ->filter(request(['search','from_date','to_date']))
            ->paginate(10);

        $tenants = Tenants::get();
        $properties = Property::get();
        
        return view('sales.index', [
            'title' => 'Sales Management',
            'tenants' => $tenants,
            'properties' => $properties,
            'sales' => $sales,
            'today_sales' => Sales::whereDate('transaction_date',date('Y-m-d'))->sum('amount'),
            'monthly_sales' => Sales::whereMonth('transaction_date',date('m'))->whereYear('transaction_date',date('Y'))->sum('amount'),
            'yearly_sales' => Sales::whereYear('transaction_date',date('Y'))->sum('amount'),
            'total_sales' => Sales::sum('amount'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalesFormRequest $request)
    {
        $this->authorize('create_sales', Sales::class);
        
        $validate = $request->validated();

        $create = Sales::create($validate);

        if($create){

            Property::find($request->property_id)->update(['status'=>'sold']); 

            return back()->with('success', 'Sales has been created successfully!');
        }

        return back()->with('error', 'Creating sales is not successful!');
    }

    /**
     * Display the specified resource.
     */
    public function find(Sales $sales)
    {
        return response()->json($sales);
    }

    public function receipt(Sales $sales)
    {

        $this->authorize('view_sales', $sales);
        
        $pdf = Pdf::loadView('sales.receipt', ['receipt' => $sales]);

        // Define the file name
        $fileName =  'receipt-'.$sales->id . date('-y-m-d-his') . '.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function report()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalesFormRequest $request)
    {
        $this->authorize('update_sales', Sales::class);

        $validate = $request->validated();

        $update = Sales::find($request->sales_id)->update($validate);

        if($update){

            return back()->with('success', 'Sales has been updated successfully!');
        }

        return back()->with('error', 'Updating sales is not successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sales)
    {
        $this->authorize('delete_sales', $sales);
        
        $sales->delete();
        
        return back()->with('success', 'Sales details has been deleted successfully!');
    }
}