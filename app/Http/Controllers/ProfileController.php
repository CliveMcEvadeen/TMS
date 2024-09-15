<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserFormRequest;

class ProfileController extends Controller
{
    public function index(){
        
        $user = auth()->user();
        
        $this->authorize('view_user', $user);
            
        return view('users.profile', compact('user'));
    }

    public function update(UserFormRequest $request, User $user){
        
        $this->authorize('update_user_', $user);

        $validate = $request->validated();

        if($request->hasFile('avatar')){
            $validate['avatar'] = $request->file('avatar')->store('avatar','public');
        }

        $user->update($validate);
        
        return  redirect()->back()->with('success','Your profile has been changed successfully!');

    }

    public function change_password(Request $request, User $user)
    {
        $this->authorize('update_user', $user);
        
        $formfields = $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user->update($formfields);

        return  redirect()->back()->with('success','Your password has been updated successfully!');
        
    }
}