<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RegisterService;
use App\Services\VendorService;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function register(Request $request, RegisterService $registerService){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'], 
            'phone_office' => ['required', 'numeric'], 
            'description' => ['required', 'string'], 
            'photo_1' => ['required', 'image', 'mimes:jpeg,jpg,png|max:5000'], 
            'photo_2' => ['nullable', 'image', 'mimes:jpeg,jpg,png|max:5000'], 
            'photo_3' => ['nullable', 'image', 'mimes:jpeg,jpg,png|max:5000'], 
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

        $result = $registerService->registerVendor($request->all());

        return $result;
    }

    public function list(VendorService $vendorService){
        $result = $vendorService->allVendor();

        return $result;
    }

    public function getById(VendorService $vendorService, $id){
        $result = $vendorService->vendorById($id);

        return $result;
    }
}
