<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Leave;
use App\Helpers\ApiResponse;

class LeaveController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:10',
            'description' => 'required|string|max:225',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $leave = Leave::create($validator->validated());
            
            return ApiResponse::successResponse($leave, 'Success Insert Leave');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Insert Leave', $th->getMessage(), 500);
        }
    }
}
