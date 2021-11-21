<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\Request;
use Validator;

class TransactionController extends Controller
{
    public function store(TransactionService $transactionService, Request $request){

        $validator = Validator::make($request->all(), [
            'vendor_id' => ['required', 'numeric'], 
            ]);

        if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed validation',
                    'message' => $validator->errors(),
                ], 400);
            }

        $result = $transactionService->requestDeposit($request->all());

        return $result;
        }

    public function accept(TransactionService $transactionService, $id){
        $result = $transactionService->acceptTransaction($id);

        return $result;
    }

    public function done(TransactionService $transactionService, $id){
        $result = $transactionService->doneTransaction($id);

        return $result;
    }

    public function cancel(TransactionService $transactionService, $id){
        $result = $transactionService->cancelTransaction($id);

        return $result;
    }

    public function listByVendor(TransactionService $transactionService){
        $result = $transactionService->listTransactionByVendor();

        return $result;
    }

    public function listByUser(TransactionService $transactionService){
        $result = $transactionService->listTransactionByUser();

        return $result;
    }
}
