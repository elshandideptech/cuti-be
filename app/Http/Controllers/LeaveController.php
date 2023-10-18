<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Leave;
use App\Helpers\ApiResponse;

class LeaveController extends Controller
{
    /**
     * fungsi untuk mengambil semua data cuti
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com>
     * @return JSON data leaves
     * created at October 14, 2023
     */
    public function index(Request $request){
        try {
            $leaves = Leave::select(
                'id',
                'title',
                'description'
            )->whereHas('language', function($query) use ($request) {
                $query->where('code', $request->header('Language'));
            })->get();

            return ApiResponse::successResponse($leaves, 'Success Get All Leaves');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Get All Leaves', $th->getMessage(), 500);
        }
    }

    /**
     * fungsi untuk mengambil data cuti berdasarkan id
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com>
     * @return JSON data leave
     * created at October 14, 2023
     */
    public function show($id){
        try {
            $leave = Leave::select(
                'id',
                'title',
                'description'
            )->find($id);

            return ApiResponse::successResponse($leave, 'Succecc Get The Leave');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Get the Leave', $th->getMessage(), 500);
        }
    }

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
            'title_id' => 'required|string|max:10',
            'description_id' => 'required|string|max:225',
            'title_en' => 'required|string|max:10',
            'description_en' => 'required|string|max:225',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            // $leave = Leave::create($validator->validated());
            $leave_indonesia = Leave::create([
                'id_language' => 1,
                'title' =>$request->title_id,
                'description' =>$request->description_id,
            ]);

            $leave_english = Leave::create([
                'id_language' => 2,
                'id_parent' => $leave_indonesia->id,
                'title' =>$request->title_en,
                'description' =>$request->description_en,
            ]);

            $leave_indonesia->id_parent = $leave_english->id;
            $leave_indonesia->save();

            $response = [
                'Indonesia' => $leave_indonesia,
                'English' => $leave_english,
            ];
            
            return ApiResponse::successResponse($response, 'Success Insert Leave');
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

    /**
     * fungsi untuk menghapus data cuti berdasarkan id
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com>
     * @return JSON status, message, and data
     * created at October 14, 2023
     */
    public function destroy($id){
        try {
            $leave = Leave::find($id);
            $leave->delete();

            return ApiResponse::successResponse($leave, 'Success Delete Leave');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Delete Leave', $th->getMessage(), 500);
        }
    }
}
