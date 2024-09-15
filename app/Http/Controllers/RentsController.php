<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Rents;
use App\Models\Sales;
use App\Models\Tenants;
use App\Models\Property;
use App\Class\RentPayment;
use App\Models\RentPayments;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\RentsRequestForm;

class RentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny_rents', Rents::class);
        
        return view('rents.index', [
            'title' => 'Rents Management',
            'rents' => Rents::with(['property','tenant'])->latest()->filter(request(['search','from_date', 'to_date']))->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create_rents', Rents::class);
        
        return view('rents.create', [
            'title' => 'Create Rents',
            'tenants' => Tenants::get(),
            'properties' => Property::where('status','vacant')->get(),
            'owners' => Owner::get(), 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RentsRequestForm $request)
    {
        $this->authorize('create_rents', Rents::class);

        $validate = $request->validated();

        $create = Rents::create($validate);
        
        if($create){

            Property::find($request->property_id)->update(['status'=>'rented']); 

            $rent_payment = new RentPayment();

            $rent_payment->insert_payments($create->id, $request->terms, $request->start_date, $request->rent_type, $request->amount, $request->discount); //insert rent payment

            return back()->with('success', 'Rents has been created successfully!');
        }

        return back()->with('error', 'Creating rent is not successful!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rents $rent)
    {
        $this->authorize('view_rents', Rents::class);

        return view('rents.view', [
            'title' => 'View Rent',
            'tenants' => Tenants::get(),
            'properties' => Property::whereIn('id', [$rent->property_id])->get(),
            'owners' => Owner::get(), 
            'rent' => $rent, 
        ]);
    }

    public function contract(Rents $rent)
    {
        $this->authorize('view_rents', Rents::class);

        return view('rents.contract', [
            'title' => 'Lease Agreement',
            'rent' => $rent, 
        ]);
    }

    public function contract_pdf(Rents $rent)
    {
        $pdf = Pdf::loadView('rents.contract-pdf', ['rent' => $rent]);

        // Define the file name
        $fileName =  'contract-'.$rent->id . date('-y-m-d-his') . '.pdf';

        return $pdf->download($fileName);
    }

    public function receipt(RentPayments $receipt)
    {
        $pdf = Pdf::loadView('rents.receipt', ['receipt' => $receipt]);

        // Define the file name
        $fileName =  'receipt-'.$receipt->id . date('-y-m-d-his') . '.pdf';

        return $pdf->download($fileName);
    }

    public function payment(Request $request)
    {
        $this->authorize('payment_rents', Rents::class);

        $payment = $request->validate([
            'date_paid' => 'required',
            'amount' => 'required',
        ]);

        $payment['status'] = 1; // change status as settled

        if($request->penalty > 0){
            $payment['amount'] = $request->amount + $request->penalty; //add penalty here
        }

        $paid = RentPayments::find($request->payment_id)->update($payment);

        if($paid){

            $rent = RentPayments::find($request->payment_id);

            $sales = [
                'status' => true,
                'amount' => $payment['amount'],
                'property_id' =>  $rent->rent->property->id,
                'tenant_id' => $rent->rent->tenant->id,
                'rent_payment_id' => $request->payment_id,
                'transaction_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]; 

            Sales::create($sales);

            return back()->with('success', 'Payments has been created successfully!');
        }

        return back()->with('error', 'Creating payment is not successful!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rents $rent)
    {
        $this->authorize('update_rents', Rents::class);

        return view('rents.edit', [
            'title' => 'Edit Rent',
            'tenants' => Tenants::get(),
            'properties' => Property::whereIn('id', [$rent->property_id])->get(),
            'owners' => Owner::get(), 
            'rent' => $rent, 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RentsRequestForm $request, Rents $rent)
    {
        $this->authorize('update_rents', Rents::class);

        $validate = $request->validated();

        $update = $rent->update($validate);
        
        if($update){

            Property::find($request->property_id)->update(['status'=>'rented']); 

            $rent_payment = new RentPayment();

            $rent_payment->update_payments($rent->id, $request->terms, $request->start_date, $request->rent_type, $request->amount, $request->discount); //update rent payment

            return back()->with('success', 'Rents has been updated successfully!');
        }

        return back()->with('error', 'Updating rent is not successful!');
    }

    public function update_status(Request $request, Rents $rent)
    {
        $this->authorize('update_rents', Rents::class);

        $update = $rent->update(['status' => $request->status]);
        
        if($update){

            if($request->status == 'ended'){
                Property::find($rent->property_id)->update(['status'=>'vacant']); 
            }

            return back()->with('success', 'Rents has been updated successfully!');
        }

        return back()->with('error', 'Updating rent is not successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rents $rent)
    {
        $this->authorize('delete_rents', Rents::class);

        $rent->delete();

        return back()->with('success', 'Rent details has been deleted successfully!');
    }
}