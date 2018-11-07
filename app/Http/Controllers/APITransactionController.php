<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;

class APITransactionController extends Controller
{
    public function purchase(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'product_id' => 'required',
                'quantity' => 'required',
                'total' => 'required',
                'status' => 'required',
            ]);

            $current_time = Carbon::now()->toDateTimeString();

            if ($validator->fails()) {
                return response()->json($validator->errors(),401);
            }

            $transaction = new Transaction;
            $transaction->user_id = $request->get('user_id');
            $transaction->product_id = $request->get('product_id');
            $transaction->quantity = $request->get('quantity');
            $transaction->total = $request->get('total');
            $transaction->status = $request->get('status');
            $transaction->timestamp = $current_time;
            $transaction->save();

            $code = "SUCCESS";
            return response()->json(compact('code'));

        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }

    public function getTransactionsByProduct(Request $request) {
        try {
            $transactions = Transaction::where('product_id',$request->product_id)
                ->with('product','user')
                ->get();

            $code = "SUCCESS";
            return response()->json(compact('transactions','code'));

        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }

    public function getTransactionsByUser(Request $request) {
        try {
            $transactions = Transaction::where('user_id',$request->user_id)
                ->with('product','user')
                ->get();

            $code = "SUCCESS";
            return response()->json(compact('transactions','code'));

        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }
}
