<?php
namespace App\Services;

use App\User;
use Exception;
use Auth;

class LoginService
{
    public function checkLogin($data)
    {
        if(!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            return response()->json(['message' => 'Wrong password'], 401);
        } else {
            try {
                $user_result = User::find(Auth::user()->id);

                if ($user_result) {
                    $token = $user_result->createToken('apiToken')->plainTextToken;
                    $user_result->remember_token = $token;
                    $user_result->save();

                    $user_types = [
                        1 => 'Super Admin',
                        2 => 'User', 
                        3 => 'Vendor', 
                    ];

                    $response = [
                        'id'    => $user_result->id,
                        'token' => $token,
                        'user_type' => isset($user_types[$user_result->user_type]) ? $user_types[$user_result->user_type] : NULL,
                        'account_verified_at' => $user_result->account_verified_at
                    ];
        
                    return response()->json([
                        'message' => 'success',
                        'data' => $response
                    ], 200);

                } else {
                    return response()->json([
                        'message' => 'User not found',
                    ], 404);
                }
        
            } catch(Exception $e){
                return response()->json(['message' => $e->getMessage()], 409);
            }
        }
    }

    public function logout()
    {   
        try {
            auth()->user()->tokens()->delete();
            return response([
                'status' => 'success',
                'message' => 'Logout successfully'
            ], 200);
        } catch(Exception $e){
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}