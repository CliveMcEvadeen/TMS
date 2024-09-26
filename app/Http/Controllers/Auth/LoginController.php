<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'g-recaptcha-response' => 'recaptcha', // recaptcha validation
    ]);

    $filteredCredentials = [
        'email' => $credentials['email'],
        'password' => $credentials['password'],
    ];

    if (Auth::attempt($filteredCredentials)) {
        // Check if the logged-in user is a tenant
        if (Auth::user()->hasRole('rental-staff')) {
            return redirect()->route('payments.index'); // Redirect to payment history
        }
        
        return redirect('dashboard'); // For other roles, redirect to the dashboard
    } else {
        return redirect()->back()->withInput()->withErrors(['email' => 'These credentials do not match our records!']);
    }
}

}