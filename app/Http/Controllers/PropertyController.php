<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyFormRequest;
use App\Models\Owner;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view_property', Property::class);
    
        return view('property.index', [
            'title' => 'Property Management',
            'owners' => Owner::get(),
            'properties' => Property::latest()->filter(request(['search']))->paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyFormRequest $request)
    {
        $this->authorize('create_property', Property::class);
        
        $validate = $request->validated();

        if($request->has('image')){
            $validate['image'] = $request->file('image')->store('property', 'public');
        }
 
        $create = Property::create($validate);

        if($create){
            return back()->with('success', 'Property has been created successfully!');
        }

        return back()->with('error', 'Creating property is not successful!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $this->authorize('view_property', Property::class);
    
        return view('property.view', [
            'title' => 'Property Details',
            'property' => $property,
        ]);
    }

    public function find(Property $property)
    {
        return response()->json($property);
    } 


    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyFormRequest $request)
    {
        $this->authorize('update_property', Property::class);
        
        $validate = $request->validated();

        if($request->has('image')){
            $validate['image'] = $request->file('image')->store('property', 'public');
        }

        $update = Property::find($request->property_id)->update($validate);

        if($update){
            return back()->with('success', 'Property has been updated successfully!');
        }

        return back()->with('error', 'Updating property is not successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $this->authorize('delete_property', Property::class);

        $property->delete();

        return back()->with('success', 'Property has been deleted successfully!');
    }
}