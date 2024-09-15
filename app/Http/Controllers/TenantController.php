<?php

namespace App\Http\Controllers;

use App\Http\Requests\TenantRequestForm;
use App\Models\Tenants;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tenants.index', [
            'title' => 'Tenants Management',
            'tenants' => Tenants::latest()->filter(request(['search']))->paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TenantRequestForm $request)
    {
        $this->authorize('create_tenant', Tenants::class);

        $validate = $request->validated();
        
        if($request->has('image')){
           $validate['image'] = $request->file('image')->store('tenant', 'public');
        }

        $create = Tenants::create($validate);

        if($create){
            return back()->with('success', 'Tenant has been created successfully!');
        }
        return back()->with('error', 'Creating tenant is not successful!');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenants $tenant)
    {
        return view('tenants.view', [
            'title' => 'Tenants Details',
            'tenant' => $tenant
        ]);
    }
    
    public function find(Tenants $tenant)
    {
        return response()->json($tenant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TenantRequestForm $request)
    {
        $this->authorize('update_tenant', Tenants::class);

        $validate = $request->validated();
        
        if($request->has('image')){
           $validate['image'] = $request->file('image')->store('tenant', 'public');
        }

        $updaet = Tenants::find($request->tenant_id)->update($validate);

        if($updaet){
            return back()->with('success', 'Tenant has been updated successfully!');
        }
        return back()->with('error', 'Updating tenant is not successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenants $tenant)
    {
        $this->authorize('delete_tenant', Tenants::class);

        $tenant->delete();

        return back()->with('success', 'Tenant has been deleted successfully!');
    }
}