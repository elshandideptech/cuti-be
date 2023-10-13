<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * fungsi untuk login user/admin
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com> 
     * @param $email email user/admin (required, max 50 characters)
     * @param $password password user/admin (required, min 8 characters)
     * @return void untuk access token login
     * created at October 13, 2023
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:50',
            'password' => "required|string|min:8"
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            if (! $token = JWTAuth::attempt($request->only('email', 'password'))) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login Succesuly', 
            'token' => $token
        ]);
    }

    /**
     * fungsi untuk logout user/admin
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com>
     * @return void untuk remove access token
     * created at October 13, 2023
     */
    public function logout(){
        if ($removeToken = JWTAuth::invalidate(JWTAuth::getToken())){
            return response()->json([
                'success' => true,
                'message' => 'Logout Succesfully!',  
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "Logout Failed"
        ], 400);
    }
}
