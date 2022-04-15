<?php

namespace App\Services;

use App\Product;
use App\ProductPhotos;
use App\ProductServices;
use Carbon\Carbon;

use DB;
use Exception;

class ProductService
{
    public function addProduct($data) {
        
        try {
            DB::beginTransaction();
            $result_product = Product::create([
                'product_number' => 'PN' . time(),
                'name' => $data['name'],
                'category_id' => $data['category_id'],
                'user_id'   => auth()->user()->id,
                'description' => $data['description'],
                'stock' => $data['stock'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            foreach($data['image'] as $image){
                if (file_exists($image)) {
                    $path = storeFileToPublic($image, 'product/'. $result_product->product_number, 'image');
                }
                $temp = ProductPhotos::create([
                    'product_id' => $result_product->id,
                    'path' => $path,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                $result[] = $temp;
            }  
            DB::commit();

            if(isset($result_product)) {
                return response()->json([
                    'message' => 'success',
                    'data' => $result_product
                ], 201);
            } else {
                return response()->json([
                    'message'   => 'failed'
                ], 401);
            }
        } catch (Exception $e) {
            return response()->json([
                'message'   => $e->getMessage()
            ], 400);
        }
    }

    public function listProduct($perPage) {
        try {
            $products = Product::with('photos')->paginate($perPage);

            return response()->json([
                'message'   => 'success',
                'data'      => $products
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function listProductbyUser($perPage) {
        try {
            $products = Product::where('user_id', '=', auth()->user()->id)
                                ->with('photos')
                                ->paginate($perPage);

            return response()->json([
                'message'   => 'success',
                'data'      => $products
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}