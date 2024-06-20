<?php

namespace App\Http\Controllers\API;

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
                'success' => false,
                'message' => 'Login Failed',
                'data' => $validator->errors()
            ], 401);
        }
    
        $data = User::where('email', $request->email)->first();
        if (!$data || !Hash::check($request->password, $data->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect Email or Password'
            ], 401);
        }
    
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect Email or Password'
            ], 401);
        }
    
        $token = $data->createToken('data-token')->plainTextToken;
    
        $message = 'Login Successfully';
        if ($data->isadmin) {
            $message .= ' - Welcome Admin';
        }
    
        return response()->json([
            'success' => true,
            'message' => $message,
            'token' => $token,
        ]);
    }
}
