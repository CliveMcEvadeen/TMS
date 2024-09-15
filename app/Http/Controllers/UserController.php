<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserFormRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view_user', User::class);

        $users = User::latest()->paginate(10);
        $roles = Role::all();
        
        return view('users.index',[
            'title' => 'User Management',
            'users' => $users,
            'roles' => $roles
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request)
    {
        $this->authorize('create_user', User::class);

        $validate = $request->validated();

        $validate['password'] = Hash::make('password');

        $user = User::create($validate);
        
        $create = $user->syncRoles($request->role);

        if($create){
            
            return back()->with('success', 'User has been created successfully!');
        }
        
        return back()->with('error', 'Creating a user is not successfull!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $data['role_id'] = $user->roles->pluck('id')[0] ?? ''; 
        $data['user'] = $user;
        
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function reset(User $user)
    {
        $this->authorize('reset_user', User::class);

        User::find($user->id)->update(['password' => Hash::make('password')]);

        return back()->with('success', 'User password has been changed successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFormRequest $request)
    {
        $this->authorize('update_user', User::class);

        $validate = $request->validated();

        User::findorFail($request->user_id)->update($validate);
        
        $user = User::findOrFail($request->user_id);
        $roles = $user->syncRoles($request->role);

        if($roles){
            
            return back()->with('success', 'User has been updated successfully!');
        }
        
        return back()->with('error', 'Updating a user is not successfull!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete_user', $user);

        $user->delete();

        return back()->with('success', 'User has been deleted successfully!');
    }
}