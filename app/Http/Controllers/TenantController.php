<?php

namespace App\Http\Controllers;

use App\Http\Requests\TenantRequestForm;
use App\Models\Tenants;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    public function index()
    {
        return view('tenants.index', [
            'title' => 'Tenants Management',
            'tenants' => Tenants::latest()->filter(request(['search']))->paginate(10)
        ]);
    }

    public function store(TenantRequestForm $request)
{
    $this->authorize('create_tenant', Tenants::class);

    // Validate tenant creation input
    $validate = $request->validated();

    // Auto-generate tenant ID
    $tenantId = 'TMS/T/' . rand(1000, 9999);

    // Use tenant ID as both email and password (plain text for now)
    $validate['email'] = $tenantId;
    $validate['password'] = $tenantId; 

    // If image is uploaded, store it
    if ($request->has('image')) {
        $validate['image'] = $request->file('image')->store('tenant', 'public');
    }

    // Store tenant ID in tenant_id field
    $validate['tenant_id'] = $tenantId;

    // Log the validation data for debugging
    Log::info('Validated tenant data:', $validate);

    // Create the corresponding user
    try {
        $createUser = \App\Models\User::create([
            'name' => $validate['name'],
            'email' => $tenantId,  // Using tenant ID as the email
            'email_verified_at' => now(),
            'password' => Hash::make($tenantId), // Hashing the password for security
        ]);

        // Log the created user
        Log::info('User created:', ['user' => $createUser]);
    } catch (\Exception $e) {
        Log::error('Error creating user:', ['error' => $e->getMessage()]);
        return back()->with('error', 'Failed to create the user.');
    }

    // Assign the 'tenant' role to the user
    $createUser->assignRole('rental-staff');
    

    // Create the tenant with the user_id set to the newly created user's ID
    try {
        $createTenant = Tenants::create([
            'name' => $validate['name'],
            'contact_no' => $validate['contact_no'],
            'email' => $validate['email'],
            'address' => $validate['address'],
            'image' => $validate['image'] ?? null,
            'tenant_id' => $tenantId,
            'password' => $tenantId,
            'user_id' => $createUser->id,
             // Set user_id to the created user's ID
        ]);

        // Log the created tenant
        Log::info('Tenant created:', ['tenant' => $createTenant]);
    } catch (\Exception $e) {
        Log::error('Error creating tenant:', ['error' => $e->getMessage()]);
        return back()->with('error', 'Failed to create the tenant.');
    }

    if ($createTenant) {
        return back()->with('success', 'Tenant has been created successfully! The tenant ID is: ' . $tenantId . ' and the password is: ' . $tenantId);
    }

    return back()->with('error', 'Creating tenant was not successful!');
}


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

    public function update(TenantRequestForm $request)
    {
        $this->authorize('update_tenant', Tenants::class);

        $validate = $request->validated();
        
        if ($request->has('image')) {
            $validate['image'] = $request->file('image')->store('tenant', 'public');
        }

        $update = Tenants::find($request->tenant_id)->update($validate);

        if ($update) {
            return back()->with('success', 'Tenant has been updated successfully!');
        }
        return back()->with('error', 'Updating tenant is not successful!');
    }

    public function destroy(Tenants $tenant)
    {
        $this->authorize('delete_tenant', Tenants::class);

        $tenant->delete();

        return back()->with('success', 'Tenant has been deleted successfully!');
    }
}
