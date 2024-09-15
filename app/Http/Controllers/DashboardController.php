<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Rents;
use App\Models\Sales;
use App\Models\Tenants;
use App\Models\Property;
use App\Models\RentPayments;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) 
    {
        return view('admin.dashboard',[
            'rents' => Rents::get()->count(),
            'properties' => Property::get()->count(),
            'tenants' => Tenants::get()->count(),
            'owners' => Owner::get()->count(),
            'propterties' => Property::get()->count(),
            'today_sales' => Sales::whereDate('transaction_date',date('Y-m-d'))->sum('amount'),
            'total_sales' => Sales::sum('amount'),
            'due_payments' => RentPayments::whereMonth('due_date',date('m'))->whereYear('due_date',date('Y'))->where('status', 0)->paginate(20),
        ]);
    }

    public function find_payment(RentPayments $payment){
        $payment['tenant_name'] = $payment->rent->tenant->name;
        return response()->json($payment);
    }

    public function sales_chart(){
        
        $data['current_sale'] = Sales::get_this_year_sales();
        $data['previous_sale'] = Sales::get_previous_year_sales();
        
        return response()->json($data);
    }

    public function properties_chart(){
        
        $data['sold'] = Property::where('status','sold')->get()->count();
        $data['rented'] = Property::where('status','rented')->get()->count();
        $data['vacant'] = Property::where('status','vacant')->get()->count();
        
        return response()->json($data);
    }
}