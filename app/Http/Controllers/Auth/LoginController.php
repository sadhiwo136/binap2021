<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
    /*{
        logout as performLogout;
    }*/

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
    protected function redirectTo()
    {
        if(Auth::user()->usertype == 'admin')
        {
            return 'dashboard';
        }
        else if(Auth::user()->usertype == 'developer')
        {
            return 'companies';
        }
        else if(Auth::user()->usertype == 'warga')
        {
            return 'laporanwarga';
        }
        else
        {
            return 'home';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->route('home');
    }*/
}
