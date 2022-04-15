<?php
namespace App\Services;

use Exception;
use App\Vendor;

class VendorService
{
    public function allVendor(){
        try {
            $result_list = Vendor::where('status', 2)
                                ->orderBy('name', 'asc')
                                ->get();

            if(isset($result_list)){
                return response()->json([
                    'message'    => 'success',
                    'data'      => $result_list,
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

    public function vendorById($id){
        try {
            $result = Vendor::find($id);

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