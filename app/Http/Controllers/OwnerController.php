<?php

namespace App\Http\Controllers;

use App\Http\Requests\OwnersFormRequest;
use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny_owners', Owner::class);
        
        return view('owner.index',[
            'title' => 'Owner Management',
            'owners' => Owner::latest()->filter(request(['search']))->paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OwnersFormRequest $request)
    {
        $this->authorize('create_owners', Owner::class);

        $validate = $request->validated();

        if($request->has('image')){
            $validate['image'] = $request->file('image')->store('owners','public');
        }

        $create = Owner::create($validate);

        if($create){
            
            return back()->with('success', 'Owner has been created successfully!');
        }
        
        return back()->with('error', 'Creating an owner is not successful!');
    }

    /**
     * Display the specified resource.
     */
    public function find(Owner $owner)
    {
        return response()->json($owner);
    }

    public function show(Owner $owner)
    {
        $this->authorize('viewAny_owners', Owner::class);

        $rents = collect();

        if ($owner) {
            $properties = $owner->properties; // Retrieve the owner's properties

            foreach ($properties as $property) {
                $rents = $rents->merge($property->rents);
            }
        }

        return view('owner.view',[
            'title' => 'Owner Details',
            'owner' => $owner,
            'rents' => $rents,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OwnersFormRequest $request)
    {
        $this->authorize('update_owners', Owner::class);

        $validate = $request->validated();

        if($request->has('image')){
            $validate['image'] = $request->file('image')->store('owners','public');
        }

        $update = Owner::find($request->owner_id)->update($validate);

        if($update){
            
            return back()->with('success', 'Owner has been updated successfully!');
        }
        
        return back()->with('error', 'Updating an owner is not successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Owner $owner)
    {
        $this->authorize('delete_owners', $owner);

        $owner->delete();

        return back()->with('success', 'Owner has been deleted successfully!');
    }
}