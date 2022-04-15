<?php
namespace App\Services;

use App\User;
use App\Vendor;
use Carbon\Carbon;
use Exception;
use DB;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function register($data){

        try{

            DB::beginTransaction();
            $result_user = User::create([
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone_number' => $data['phone_number'],
                'date_of_birth' => $data['date_of_birth'],
                'address' => $data['address'],
                'langitude' => $data['langitude'],
                'longitude' => $data['longitude'],
                'phone_type' => $data['phone_type'],
            ]);

            $result_user->assignRole('User');

            if (file_exists($data['avatar'])) {
                $result_user->avatar = storeFileToPublic($data['avatar'], $result_user->id, 'avatar');
            }

            $result_user->save();

            DB::commit();

            if(isset($result_user)){
                return response()->json([
                    'message'    => 'success',
                    'data'      => $result_user,
                ], 201);
            } else {
                return response()->json([
                    'message'    => 'failed register'
                ], 401);
            }

        } catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 409);
        }

    }

    public function registerVendor($data)
    {   
        try {
            DB::beginTransaction();
            $result_vendor = Vendor::create([
                'user_id' => auth()->user()->id,
                'name'  => $data['name'],
                'phone_office' => $data['phone_office'],
                'description' => $data['description'],
                'address' => $data['address'],
                'langitude' => $data['langitude'],
                'longitude' => $data['longitude'],
                'photo_1' => ''
            ]);
            
            if (file_exists($data['photo_1'])) {
                $result_vendor->photo_1 = storeFileToPublic($data['photo_1'], $result_vendor->user_id, 'vendor/photo_1');
                $result_vendor->save();
            }

            if (file_exists($data['photo_2'])) {
                $result_vendor->photo_2 = storeFileToPublic($data['photo_2'], $result_vendor->user_id, 'vendor/photo_2');
                $result_vendor->save();
            }

            if (file_exists($data['photo_3'])) {
                $result_vendor->photo_3 = storeFileToPublic($data['photo_3'], $result_vendor->user_id, 'vendor/photo_3');
                $result_vendor->save();
            }
            
            $user = new User;
            $result_user = $user->find($result_vendor->user_id);
            $result_user->user_type = 3;
            $result_user->save();

            $result_user->syncRoles('Vendor');

            DB::commit();
            
            if(isset($result_vendor)){
                return response()->json([
                    'message'    => 'success',
                    'data'      => $result_vendor,
                ], 201);
            } else {
                return response()->json([
                    'message'    => 'failed register'
                ], 401);
            }


        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 409);
        }
    }

    public function verifAccount($id){
        try {
            $data = User::find($id);
            $data->account_verified_at = Carbon::now();
            $result = $data->save();

            if(isset($result)){
                return response()->json([
                    'message'    => 'success',
                    'data'      => $result
                ], 200);
            } else {
                return response()->json([
                    'message'    => 'failed'
                ], 400);
            }
            
        } catch (Exception $e) {
            return response()->json([
                'message'    => $e->getMessage()
            ], 400);
        }
    }
}