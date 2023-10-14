<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use App\Helpers\ApiResponse;

class EmployeeController extends Controller
{
    /**
     * fungsi untuk mengambil semua data karyawan
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com>
     * @return JSON data employees
     * created at October 13, 2023
     */
    public function index(){
        try {
            $employees = Employee::select(
                'id',
                'first_name',
                'last_name',
                'email',
                'phone_number',
                'address',
                'gender'
            )->get();

            return ApiResponse::successResponse($employees, 'Success Get All Empoyees');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Get All Employees', $th->getMessage(), 500);
        }
    }

    /**
     * fungsi untuk mengambil data karyawan berdasarkan id
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com>
     * @return JSON data employee
     * created at October 13, 2023
     */
    public function show($id){
        try {
            $employee = Employee::select(
                'id',
                'first_name',
                'last_name',
                'email',
                'phone_number',
                'address',
                'gender'
            )->find($id);

            return ApiResponse::successResponse($employee, 'Succecc Get The Employee');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Get the Employee', $th->getMessage(), 500);
        }
    }
    
    /**
     * fungsi untuk membuat data karyawan baru
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com> 
     * @param $first_name First Name of employee (required, max 20 characters)
     * @param $last_name Last Name of employee (required, max 20 characters)
     * @param $email email employee (required, max 50 characters)
     * @param $phone_number phone number employee (required, max 15 characters)
     * @param $address address employee (required, max 255 characters)
     * @param $gender gender employee (required, max 10 characters, in: Laki-Laki/Perempuan)
     * @return void success message and data inserted
     * created at October 13, 2023
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email|max:50',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'gender' => 'required|string|max:10|in:Laki-Laki,Perempuan'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $employee = Employee::create($validator->validated());
            
            return ApiResponse::successResponse($employee, 'Success Insert Emloyee');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Insert Employee', $th->getMessage(), 500);
        }
    }

    /**
     * fungsi untuk mengubah data karyawan
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com> 
     * @param $first_name First Name of employee (required, max 20 characters)
     * @param $last_name Last Name of employee (required, max 20 characters)
     * @param $email email employee (required, max 50 characters)
     * @param $phone_number phone number employee (required, max 15 characters)
     * @param $address address employee (required, max 255 characters)
     * @param $gender gender employee (required, max 10 characters, in: Laki-Laki/Perempuan)
     * @return void success message and data updated
     * created at October 13, 2023
     */
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email|max:50',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'gender' => 'required|string|max:10|in:Laki-Laki,Perempuan'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $employee = Employee::find($id);
            $employee->update($validator->validated());

            return ApiResponse::successResponse($employee, 'Success Update Employee');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Update Employee', $th->getMessage(), 500);
        }
    }

    /**
     * fungsi untuk menghapus data karyawan berdasarkan id
     * * @author Elshandi Septiawan <elshandi@deptechdigital.com>
     * @return JSON status, message, and data
     * created at October 13, 2023
     */
    public function destroy($id){
        try {
            $employee = Employee::find($id);
            $employee->delete();

            return ApiResponse::successResponse($employee, 'Success Delete Employee');
        } catch (\Throwable $th) {
            return ApiResponse::errorResponse('Failed Delete Employee', $th->getMessage(), 500);
        }
    }
}
