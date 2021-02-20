<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('email','password');
        $token = null;

        if(!$token = JWTAuth::attempt($credentials)){
            return response()->json([
                'status' => false,
                'error' => 'Email veya şifre yanlış.'
            ]);
        }
        
        return response()->json([
            'status' => true,
            'token' => $token
        ]);

    }
    public function logout(Request $request){
        try{
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'status' => true
            ]);
            
        }catch(JWTException $e){
            return response()->json([
                'status' => false
            ]);
        }
    }
}
