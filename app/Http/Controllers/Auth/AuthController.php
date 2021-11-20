<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\RegisterService;
use App\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function store(RegisterService $registerService, Request $request){
        $validator = Validator::make($request->all(), [
            'full_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'], 
            'password' => ['required', 'string'], 
            'phone_number' => ['required', 'numeric'], 
            'date_of_birth' => ['required', 'date'], 
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png|max:5000'], 
            'address' => ['required', 'string'], 
            'langitude' => ['required', 'string'], 
            'longitude' => ['required', 'string'], 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed validation',
                'message' => $validator->errors(),
            ], 401);
        }

        $result = $registerService->register($request->all());

        return $result;
    }

    public function login(LoginService $loginService, Request $request)
    {
        $rules = [
            'email' => [
                'required', 'email', 
                Rule::exists('users')->where(function ($query) use ($request) {
                    $query->where('email', $request->email)
                        ->whereNotNull('account_verified_at')
                        ->whereNull('deleted_at');
                })
            ],
            'password' => [
                'required', 'string'
            ]
        ];

        $validator = Validator::make($request->all(), $rules, [
            'email.exists' => 'Unregistered email or the account is not activated.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 404);
        }

        $result = $loginService->checkLogin($request->all());

        return $result;
    }

    public function logout(LoginService $loginService)
    {
        $result = $loginService->logout();

        return $result;
    }

    public function verif(RegisterService $registerService, $id){
        $result = $registerService->verifAccount($id);

        return $result;
    }
}