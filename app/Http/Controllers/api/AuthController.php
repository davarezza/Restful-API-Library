<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Login Failed',
                'data' => $validator->errors()
            ], 401);
        }
    
        $data = User::where('email', $request->email)->first();
        if (!$data || !Hash::check($request->password, $data->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Incorrect Email or Password'
            ], 401);
        }
    
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Incorrect Email or Password'
            ], 401);
        }
    
        $token = $data->createToken('data-token')->plainTextToken;
    
        return response()->json([
            'status' => true,
            'message' => 'Login Successfully',
            'token' => $token,
        ]);
    }
}
