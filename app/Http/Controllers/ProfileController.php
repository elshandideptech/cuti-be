<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Helpers\ApiResponse;

class ProfileController extends Controller
{
    /**
     * fungsi untuk mengubah data user
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com> 
     * @param $first_nama First Name of User (required, max 20 characters)
     * @param $last_nama Last Name of User (required, max 20 characters)
     * @param $email Email of User (required, max 50 characters)
     * @return void success message and data inserted
     * created at October 14, 2023
     */
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $user = User::find(auth()->user()->id);
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
            ]);
            
            return ApiResponse::successResponse($user, 'Success Update User');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Update User', $th->getMessage(), 500);
        }
    }
}
