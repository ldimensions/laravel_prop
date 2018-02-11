<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests;
use JWTAuth;
use JWTAuthException;
use App\User;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    //protected $redirectTo = '/home';

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
        $this->user = new User;
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'statusCode' => 401,                                    
                    'message' => 'Invalid username and password.',
                ],401);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'status' => 'error',
                'statusCode' => 401,                
                'message' => 'Unable to login this time. Pleaes try again.',
            ],401);
        }
        return response()->json([
            'status' => 'success',
            'statusCode' => 200,
            'result' => [
                'token' => $token,
            ],
        ],200);
    }

    public function getAuthUser(Request $request){
        $user = JWTAuth::toUser($request->token);        
        return response()->json(['result' => $user]);
    }



}
