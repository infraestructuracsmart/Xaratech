<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * Login del sistema
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $auth = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if(!$auth){
            abort(401, 'Credenciales incorrectas.');
        }
        $token = Auth::user()->createToken('API Token')->accessToken;
        return response()->json([
            'data' => Auth::user(),
            'token' => $token
        ]);
    }

    /**
     * Logout del sistema
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(){
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json([
            'message' => 'Se finalizo la sesión correctamente'
        ]);        
    }
}
