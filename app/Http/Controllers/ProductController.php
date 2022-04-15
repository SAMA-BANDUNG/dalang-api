<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use Validator;

class ProductController extends Controller
{
    public function store(ProductService $productService, Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'category_id' => ['required'],
            'description' => ['required'],
            'stock' => ['required'],
            'image' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed validation',
                'message' => $validator->errors(),
            ], 400);
        }
        
        $result = $productService->addProduct($request->all());

        return $result;
    }

    public function index(ProductService $productService, Request $request) {
        $result = $productService->listProduct($request->get('perPage') );

        return $result;
    }

    public function myProduct(ProductService $productService, Request $request) {
        $result = $productService->listProductByUser($request->get('perPage') );

        return $result;
    }
}
