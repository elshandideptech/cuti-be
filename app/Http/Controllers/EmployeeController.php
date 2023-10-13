<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;

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

            return response()->json([
                'status' => true,
                'message' => 'Success Get All Empoyees',
                'data' => $employees
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'userMessage' => 'Failed Get All Employees',
                'developerMessage' => $th->getMessage()
            ], 500);
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
            $employees = Employee::select(
                'id',
                'first_name',
                'last_name',
                'email',
                'phone_number',
                'address',
                'gender'
            )->find($id);

            return response()->json([
                'status' => true,
                'message' => 'Success Get The Employee',
                'data' => $employees
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'userMessage' => 'Failed Get The Employee',
                'developerMessage' => $th->getMessage()
            ], 500);
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
            
            return response()->json([
                    'status' => true, 
                    'message' => 'Success Insert Data', 
                    'data' => $employee
                ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'userMessage' => 'Failed to Insert Employee',
                'developerMessage' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * fungsi untuk mengubah data karyawan baru
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

            return response()->json([
                'status' => true, 
                'message' => 'Success Update Emloyee', 
                'data' => $employee]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'userMessage' => 'Failed to Update Employee',
                'developerMessage' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id){
        
    }
}
