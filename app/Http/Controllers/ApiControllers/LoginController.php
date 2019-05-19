<?php

namespace SiAtmo\Http\Controllers\ApiControllers;

use SiAtmo\User;
use SiAtmo\Http\Controllers\Controller;
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
            return response()->json($user);
        }
        else 
            return response()->json(error);
    }
}
