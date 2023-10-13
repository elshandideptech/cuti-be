<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index(){

    }

    public function show($id){

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
            
            return response()->json(['status' => true, 'message' => 'Success Insert Data', 'data' => $employee]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function update(Request $request, $id){

    }

    public function destroy($id){
        
    }
}
