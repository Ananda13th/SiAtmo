<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

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

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)
                    ->where('password',md5($request->password))
                    ->first();
        Auth::login($user);
        if($user->idPosisi == 1) {
            echo json_encode((array('user'=>$user)));
            return redirect()->intended('/owner');
        }
        else if($user->idPosisi == 2)
        {
            return redirect()->intended('/cs');
        }
        else if($user->idPosisi == 2)
        {
            return redirect()->intended('/kasir');
        }
    }

    // protected function authenticated($request, $user)
    // {
    //     if($user->idPosisi == 1) {
    //         return redirect()->intended('/owner');
    //     }
    //     if($user->idPosisi == 2)
    //     {
    //         return redirect()->intended('/cs');
    //     }
    //     if($user->idPosisi == 2)
    //     {
    //         return redirect()->intended('/kasir');
    //     }
    //     return redirect()->intended('/');
    // }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
