<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EmployeeTakeLeave;
use App\Helpers\ApiResponse;

class EmployeeTakeLeaveController extends Controller
{
    /**
     * fungsi untuk mengambil semua data cuti karyawan
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com>
     * @return JSON data employee take leaves
     * created at October 15, 2023
     */
    public function index(){
        try {
            $employee_take_leaves = EmployeeTakeLeave::select(
                'id',
                'id_employee',
                'id_leave',
                'start_date',
                'end_date',
            )->get();

            return ApiResponse::successResponse($employee_take_leaves, 'Success Get All Empoyee Take Leave');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Get All Employee Take Leave', $th->getMessage(), 500);
        }
    }

    /**
     * fungsi untuk mengambil data cuti karyawan berdasarkan id
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com>
     * @return JSON data employee take leave
     * created at October 15, 2023
     */
    public function show($id){
        try {
            $employee_take_leave = EmployeeTakeLeave::select(
                'id',
                'id_employee',
                'id_leave',
                'start_date',
                'end_date',
            )->find($id);

            return ApiResponse::successResponse($employee_take_leave, 'Success Get Empoyee Take Leave');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Get Employee Take Leave', $th->getMessage(), 500);
        }
    }

    /**
     * fungsi untuk membuat data karyawan mengambil cuti
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com> 
     * @param $id_employee employee's id who take leave (required, integer)
     * @param $id_leave leave's id will be taken (required, integer)
     * @param $start_date date when employee start leave (required, date, date format:YYYY-MM-DD)
     * @param $end_date date when employee end leave (required, date, date format:YYYY-MM-DD, after start date)
     * @return void success message and data inserted
     * created at October 15, 2023
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'id_employee' => 'required|integer',
            'id_leave' => 'required|integer',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $employee_take_leave = EmployeeTakeLeave::create($validator->validated());
            
            return ApiResponse::successResponse($employee_take_leave, 'Success Insert Employee Take Leave');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Insert Employee Take Leave', $th->getMessage(), 500);
        }
    }

    /**
     * fungsi untuk mengubah data karyawan mengambil cuti
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com> 
     * @param $id_employee employee's id who take leave (required, integer)
     * @param $id_leave leave's id will be taken (required, integer)
     * @param $start_date date when employee start leave (required, date, date format:YYYY-MM-DD)
     * @param $end_date date when employee end leave (required, date, date format:YYYY-MM-DD, after start date)
     * @return void success message and data updated
     * created at October 15, 2023
     */
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'id_employee' => 'required|integer',
            'id_leave' => 'required|integer',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $employee_take_leave = EmployeeTakeLeave::find($id);
            $employee_take_leave->update($validator->validated());
            
            return ApiResponse::successResponse($employee_take_leave, 'Success Update Employee Take Leave');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Update Employee Take Leave', $th->getMessage(), 500);
        }
    }
}
