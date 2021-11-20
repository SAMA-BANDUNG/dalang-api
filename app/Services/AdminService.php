<?php
namespace App\Services;

use App\Vendor;
use Exception;

class AdminService
{
    public function verifVendor($id){
        try {
            $data = Vendor::find($id);
            $data->status = 1;
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
                'message'    => $e
            ], 400);
        }
    }
}