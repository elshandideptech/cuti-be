<?php

namespace App\Helpers;

class ApiResponse
{
    static function successResponse($data, $message = null, $code = 200)
	{
		return response()->json([
			'status'=> 'Success', 
			'message' => $message, 
			'data' => $data
		], $code);
	}

	static function errorResponse($userMessage = null, $developerMessage = null, $code)
	{
		return response()->json([
			'status'=>'Error',
			'userMessage' => $userMessage,
            'developerMessage' => $developerMessage 
		], $code);
	}
}