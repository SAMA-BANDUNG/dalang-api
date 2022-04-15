<?php
namespace App\Services;

use App\Transaction;
use App\TransactionCategory;
use App\User;
use DB;
use Exception;

class TransactionService
{
    public function requestDeposit($data) {
        try {
            DB::beginTransaction();
            $result_transaction = Transaction::create([
                'user_id' => auth()->user()->id,
                'vendor_id' => $data['vendor_id'],
                'transaction_number' => 'TSNDL' . time(),
            ]);

            foreach($data['item'] as $item){
                $temp = TransactionCategory::create([
                    'transaction_id' => $result_transaction->id,
                    'category_id' => $item['category_id'],
                    'weight' => $item['weight']
                ]);
                $result[] = $temp;
            }

            $transCategory = TransactionCategory::where('transaction_id', $result_transaction->id)
                                            ->with('category')    
                                            ->get();
            foreach($transCategory as $value){
                $dumpVal1 = $value->weight;
                $dumpVal2 = $value->category[0]->point;

                $arrayWeight[] = $dumpVal1;
                $arrayPoint[] = $dumpVal2;
            }

            $result_transaction->total_weight = array_sum($arrayWeight);
            $result_transaction->total_point = array_sum($arrayPoint);
            $result_transaction->save();
            DB::commit();

            if(isset($result_transaction)){
                return response()->json([
                    'message'    => 'success',
                    'data'      => $result_transaction
                ], 200);
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

    public function acceptTransaction($id){
        
        try{
            $data = Transaction::find($id);
            $data->status = 1;
            $result_transaction = $data->save();

            if(isset($result_transaction)){
                return response()->json([
                    'message'    => 'success',
                    'data'      => $result_transaction
                ], 200);
            } else {
                return response()->json([
                    'message'    => 'failed'
                ], 400);
            }
            
        } catch(Exception $e) {
            return response()->json([
                'message'    => $e->getMessage()
            ], 400);
        }
    }

    public function doneTransaction($id){
        try{
            $data = Transaction::find($id);
            $data->status = 2;
            $result_transaction = $data->save();

            if(isset($result_transaction)){
                return response()->json([
                    'message'    => 'success',
                    'data'      => $result_transaction
                ], 200);
            } else {
                return response()->json([
                    'message'    => 'failed'
                ], 400);
            }
            
        } catch(Exception $e) {
            return response()->json([
                'message'    => $e->getMessage()
            ], 400);
        }
    }

    public function cancelTransaction($id){
        try{
            $data = Transaction::find($id);
            $data->status = 3;
            $result_transaction = $data->save();

            if(isset($result_transaction)){
                return response()->json([
                    'message'    => 'success',
                    'data'      => $result_transaction
                ], 200);
            } else {
                return response()->json([
                    'message'    => 'failed'
                ], 400);
            }
            
        } catch(Exception $e) {
            return response()->json([
                'message'    => $e->getMessage()
            ], 400);
        }
    }

    public function  listTransactionByVendor(){
        try{
            $user = User::where('id', auth()->user()->id)
                        ->with('vendor')
                        ->get();
            $id_vendor = isset($user[0]->vendor[0]) ? $user[0]->vendor[0]->id : 'null';
            $result_transaction = Transaction::where('vendor_id', $id_vendor)
                                            ->get();
            if(isset($result_transaction)){
                return response()->json([
                    'message'   => 'success',
                    'data'      => $result_transaction
                ], 200);
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

    public function  listTransactionByUser(){
        try{
            $result_transaction = Transaction::where('user_id', auth()->user()->id)
                                            ->get();
            if(isset($result_transaction)){
                return response()->json([
                    'message'    => 'success',
                    'data'      => $result_transaction
                ], 200);
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
    
    public function userHero() {
        
    }
}