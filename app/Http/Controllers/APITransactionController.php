<?php

namespace App\Http\Controllers;

use App\Product;
use App\Timeline;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mockery\Exception;
use Validator;

class APITransactionController extends Controller
{
    public function order(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'product_id' => 'required',
                'quantity' => 'required',
                'total' => 'required',
            ]);

            $user = User::find($request->user_id);
            if ($user==null) {
                $code = "FAILED";
                $description = "User not found";
                return response()->json(compact('code','description'));
            }

            $product = Product::find($request->product_id);
            if ($product==null) {
                $code = "FAILED";
                $description = "Product not found";
                return response()->json(compact('code','description'));
            }

            if ($validator->fails()) {
                return response()->json($validator->errors(),401);
            }

            $transaction = new Transaction;
            $transaction->user_id = $request->get('user_id');
            $transaction->product_id = $request->get('product_id');
            $transaction->quantity = $request->get('quantity');
            $transaction->total = $request->get('total');
            $transaction->status = 'Ordered';
            $transaction->save();

            $current_time = Carbon::now()->toDateTimeString();

            $timeline = new Timeline;
            $timeline->transaction_id = $transaction->id;
            $timeline->ordered_at = $current_time;
            $timeline->save();

            $code = "SUCCESS";
            return response()->json(compact('code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function cancel(Request $request) {
        try {
            $transaction = Transaction::where('id',$request->transaction_id)->first();

            if (sizeof($transaction)==0) {
                $code = "FAILED";
                $description = "Transaction not found";
                return response()->json(compact('code','description'));
            }

            $current_time = Carbon::now()->toDateTimeString();

            $transaction->status = "Cancelled";
            $transaction->save();

            $timeline = Timeline::where('transaction_id',$request->transaction_id)->first();
            $timeline->cancelled_at = $current_time;
            $timeline->save();

            $code = "SUCCESS";
            return response()->json(compact('code'));
        } catch (Exception $exception) {

        }
    }

    public function pay(Request $request) {
        try {
            $transaction = Transaction::where('id',$request->transaction_id)->first();

            if (sizeof($transaction)==0) {
                $code = "FAILED";
                $description = "Transaction not found";
                return response()->json(compact('code','description'));
            }

            $current_time = Carbon::now()->toDateTimeString();

            $transaction->status = "Paid";
            $transaction->save();

            $timeline = Timeline::where('transaction_id',$request->transaction_id)->first();
            $timeline->paid_at = $current_time;
            $timeline->save();

            $code = "SUCCESS";
            return response()->json(compact('code'));
        } catch (Exception $exception) {

        }
    }

    public function send(Request $request) {
        try {
            $transaction = Transaction::where('id',$request->transaction_id)->first();

            if (sizeof($transaction)==0) {
                $code = "FAILED";
                $description = "Transaction not found";
                return response()->json(compact('code','description'));
            }

            $current_time = Carbon::now()->toDateTimeString();

            $transaction->status = "Sent";
            $transaction->save();

            $timeline = Timeline::where('transaction_id',$request->transaction_id)->first();
            $timeline->sent_at = $current_time;
            $timeline->save();

            $code = "SUCCESS";
            return response()->json(compact('code'));
        } catch (Exception $exception) {

        }
    }

    public function arrive(Request $request) {
        try {
            $transaction = Transaction::where('id',$request->transaction_id)->first();

            if (sizeof($transaction)==0) {
                $code = "FAILED";
                $description = "Transaction not found";
                return response()->json(compact('code','description'));
            }

            $current_time = Carbon::now()->toDateTimeString();

            $transaction->status = "Arrived";
            $transaction->save();

            $timeline = Timeline::where('transaction_id',$request->transaction_id)->first();
            $timeline->arrived_at = $current_time;
            $timeline->save();

            $code = "SUCCESS";
            return response()->json(compact('code'));
        } catch (Exception $exception) {

        }
    }

    public function confirm(Request $request) {
        try {
            $transaction = Transaction::where('id',$request->transaction_id)->first();

            if (sizeof($transaction)==0) {
                $code = "FAILED";
                $description = "Transaction not found";
                return response()->json(compact('code','description'));
            }

            $current_time = Carbon::now()->toDateTimeString();

            $transaction->status = "Finished";
            $transaction->save();

            $timeline = Timeline::where('transaction_id',$request->transaction_id)->first();
            $timeline->confirmed_at = $current_time;
            $timeline->save();

            $code = "SUCCESS";
            return response()->json(compact('code'));
        } catch (Exception $exception) {

        }
    }

    public function getTransactionsByProduct(Request $request) {
        try {
            $transactions = Transaction::where('product_id',$request->product_id)
                ->with('user')
                ->get();

            $product = Product::withTrashed()
                ->where('id',$request->product_id)
                ->with('images')
                ->get();

            $code = "SUCCESS";
            return response()->json(compact('product','transactions','code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function getTransactionsByUser(Request $request) {
        try {
            $user = User::where('id',$request->user_id)
                ->with('role')
                ->first();

            $transactions = Transaction::where('user_id',$request->user_id)
                ->with('product','product.store','product.images')
                ->get();

            $code = "SUCCESS";
            return response()->json(compact('products','user','transactions','code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function getTransactionsById(Request $request) {
        try {
            $transactions = Transaction::where('id',$request->transaction_id)
                ->with('product','product.store','product.images','user','timeline')
                ->first();

            if ($transactions==null) {
                $code = "FAILED";
                $description = "Transaction not found";
                return response()->json(compact('code','description'));
            }
            $code = "SUCCESS";
            return response()->json(compact('transactions','code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }
}
