<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * fungsi untuk membuat data user
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com> 
     * @param $first_nama First Name of User (required, max 20 characters)
     * @param $last_nama Last Name of User (required, max 20 characters)
     * @param $email Email of User (required, max 50 characters)
     * @param $password Pasword of User (required, min 8 characters, must confirmed)
     * @param $password_confirmation Confirmatin of Pasword (required, min 8 characters)
     * @return void success message and data inserted
     * created at October 14, 2023
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email|max:50',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
            return ApiResponse::successResponse($user, 'Success Insert User');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Insert User', $th->getMessage(), 500);
        }
    }
}
