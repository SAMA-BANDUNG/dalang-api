<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
   public function addCategory(CategoryService $categoryService, Request $request){
       $validator = Validator::make($request->all(), [
        'name' => ['required', 'string'], 
        'point' => ['required', 'numeric'],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'failed validation',
            'message' => $validator->errors(),
        ], 400);
    }
       $result = $categoryService->store($request->all());

       return $result;
   }

   public function listCategory(CategoryService $categoryService){
       $result = $categoryService->list();

       return $result;
   }
}
