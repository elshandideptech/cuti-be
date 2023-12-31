<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    EmployeeController,
    LeaveController,
    UserController,
    ProfileController,
    EmployeeTakeLeaveController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/login', [AuthController::class, 'login']);

Route::group(['prefix'=>'/v1'], function(){
    Route::group(['prefix'=>'/auth'], function(){
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.jwt');
        Route::get('/check-authentication', [AuthController::class, 'authentication'])->middleware('auth.jwt');
    });
    Route::group(['prefix' => 'employees', 'middleware' => 'auth.jwt'], function(){
        Route::get('/', [EmployeeController::class, 'index']);
        Route::get('/{id}', [EmployeeController::class, 'show']);
        Route::post('/', [EmployeeController::class, 'store']);
        Route::put('/{id}', [EmployeeController::class, 'update']);
        Route::delete('/{id}', [EmployeeController::class, 'destroy']);
    });
    Route::group(['prefix' => 'leaves', 'middleware' => 'auth.jwt'], function(){
        Route::get('/', [LeaveController::class, 'index']);
        Route::get('/{id}', [LeaveController::class, 'show']);
        Route::post('/', [LeaveController::class, 'store']);
        Route::put('/{id}', [LeaveController::class, 'update']);
        Route::delete('/{id}', [LeaveController::class, 'destroy']);
    });
    Route::group(['prefix' => 'users', 'middleware' => 'auth.jwt'], function(){
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });
    Route::group(['prefix' => 'profile', 'middleware' => 'auth.jwt'], function(){
        Route::get('/', [ProfileController::class, 'index']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::put('/password', [ProfileController::class, 'changePassword']);
    });
    Route::group(['prefix' => 'employee-take-leaves', 'middleware' => 'auth.jwt'], function(){
        Route::get('/', [EmployeeTakeLeaveController::class, 'index']);
        Route::get('/{id}', [EmployeeTakeLeaveController::class, 'show']);
        Route::post('/', [EmployeeTakeLeaveController::class, 'store']);
        Route::put('/{id}', [EmployeeTakeLeaveController::class, 'update']);
        Route::delete('/{id}', [EmployeeTakeLeaveController::class, 'destroy']);
    });
});
