<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Leave;
use App\Helpers\ApiResponse;

class LeaveController extends Controller
{
    /**
     * fungsi untuk membuat data cuti
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com> 
     * @param $title Title of leave (required, max 10 characters)
     * @param $description Description of leave (required, max 255 characters)
     * @return void success message and data inserted
     * created at October 14, 2023
     */
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

    /**
     * fungsi untuk mengubah data cuti
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com> 
     * @param $title Title of leave (required, max 10 characters)
     * @param $description Description of leave (required, max 255 characters)
     * @return void success message and data updated
     * created at October 14, 2023
     */
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:10',
            'description' => 'required|string|max:225',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $leave = Leave::find($id);
            $leave->update($validator->validated());

            return ApiResponse::successResponse($leave, 'Success Update Leave');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Update Leave', $th->getMessage(), 500);
        }
    }
}
