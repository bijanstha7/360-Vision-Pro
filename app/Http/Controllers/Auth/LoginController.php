<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected function authenticated()
    {
        if (Auth::user()->status == 0) {
            return redirect('/')->with('warning', 'Your status is blocked, please contact super admin!');
        } else {
            if (Auth::user()->role == 1) {
                return redirect('admin')->with('success', 'Welcome to admin dashboard');
            } else {
                return redirect('/')->with('success', 'Log in successfully');
            }
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  
}
