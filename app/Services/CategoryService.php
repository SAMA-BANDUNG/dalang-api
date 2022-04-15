<?php

namespace App\Services;

use App\Category;
use Exception;

class CategoryService
{
    public function store($data) {
        try{
            $result_category = Category::create([
                'name' => $data['name'],
                'point' => $data['point'],
            ]);

            if(isset($result_category)){
                return response()->json([
                    'message'    => 'success',
                    'data'      => $result_category
                ], 201);
            } else {
                return response()->json([
                    'message'    => 'failed'
                ], 400);
            }
        } catch (Exception $e){
            return response()->json([
                'message'    => $e->getMessage()
            ], 400);
        }
    }

    public function list(){
        try {
            $result_category = Category::all();

            if(isset($result_category)){
                return response()->json([
                    'message'    => 'success',
                    'data'      => $result_category
                ], 200);
            } else {
                return response()->json([
                    'message'    => 'No Data'
                ], 404);
            }
        } catch (Exception $e){
            return response()->json([
                'message'    => $e->getMessage()
            ], 400);
        }
    }
}