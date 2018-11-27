<?php

namespace App\Http\Controllers;

use App\Product;
use App\Store;
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

            $product = Product::where('id',$transaction->product_id)
                ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                    'store_id', 'created_at', 'updated_at', 'deleted_at')
                ->with('store', 'store.user')
                ->first();

            $images = Product::where('id', $product->id)
                ->select('image1','image2','image3','image4','image5')
                ->first()
                ->toArray();

            $imArray = [];
            foreach ($images as $link) {
                if ($link!=null) {
                    array_push($imArray, compact('link'));
                }
            }
            $product->images = $imArray;
            $transaction->product = $product;

            $code = "SUCCESS";
            return response()->json(compact('code','transaction','timeline'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function cancel(Request $request) {
        try {
            $transaction = Transaction::where('id',$request->transaction_id)->first();

            if ($transaction==null) {
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

            $product = Product::where('id',$transaction->product_id)
                ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                    'store_id', 'created_at', 'updated_at', 'deleted_at')
                ->with('store', 'store.user')
                ->first();

            $images = Product::where('id', $product->id)
                ->select('image1','image2','image3','image4','image5')
                ->first()
                ->toArray();

            $imArray = [];
            foreach ($images as $link) {
                if ($link!=null) {
                    array_push($imArray, compact('link'));
                }
            }
            $product->images = $imArray;
            $transaction->product = $product;

            $code = "SUCCESS";
            return response()->json(compact('code','transaction','timeline'));
        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function pay(Request $request) {
        try {
            $transaction = Transaction::where('id',$request->transaction_id)->first();

            if ($transaction==null) {
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

            $product = Product::where('id',$transaction->product_id)
                ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                    'store_id', 'created_at', 'updated_at', 'deleted_at')
                ->with('store', 'store.user')
                ->first();

            $images = Product::where('id', $product->id)
                ->select('image1','image2','image3','image4','image5')
                ->first()
                ->toArray();

            $imArray = [];
            foreach ($images as $link) {
                if ($link!=null) {
                    array_push($imArray, compact('link'));
                }
            }
            $product->images = $imArray;
            $transaction->product = $product;

            $code = "SUCCESS";
            return response()->json(compact('code','transaction','timeline'));
        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function send(Request $request) {
        try {
            $transaction = Transaction::where('id',$request->transaction_id)->first();

            if ($transaction==null) {
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

            $product = Product::where('id',$transaction->product_id)
                ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                    'store_id', 'created_at', 'updated_at', 'deleted_at')
                ->with('store', 'store.user')
                ->first();

            $images = Product::where('id', $product->id)
                ->select('image1','image2','image3','image4','image5')
                ->first()
                ->toArray();

            $imArray = [];
            foreach ($images as $link) {
                if ($link!=null) {
                    array_push($imArray, compact('link'));
                }
            }
            $product->images = $imArray;
            $transaction->product = $product;

            $code = "SUCCESS";
            return response()->json(compact('code','transaction','timeline'));
        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function arrive(Request $request) {
        try {
            $transaction = Transaction::where('id',$request->transaction_id)->first();

            if ($transaction==null) {
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

            $product = Product::where('id',$transaction->product_id)
                ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                    'store_id', 'created_at', 'updated_at', 'deleted_at')
                ->with('store', 'store.user')
                ->first();

            $images = Product::where('id', $product->id)
                ->select('image1','image2','image3','image4','image5')
                ->first()
                ->toArray();

            $imArray = [];
            foreach ($images as $link) {
                if ($link!=null) {
                    array_push($imArray, compact('link'));
                }
            }
            $product->images = $imArray;
            $transaction->product = $product;

            $code = "SUCCESS";
            return response()->json(compact('code','transaction','timeline'));
        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function confirm(Request $request) {
        try {
//            dd($request);
            $transaction = Transaction::where('id',$request->transaction_id)->first();

            if ($transaction==null) {
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

            $product = Product::where('id',$transaction->product_id)
                ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                    'store_id', 'created_at', 'updated_at', 'deleted_at')
                ->with('store', 'store.user')
                ->first();

            $images = Product::where('id', $product->id)
                ->select('image1','image2','image3','image4','image5')
                ->first()
                ->toArray();

            $imArray = [];
            foreach ($images as $link) {
                if ($link!=null) {
                    array_push($imArray, compact('link'));
                }
            }
            $product->images = $imArray;
            $transaction->product = $product;

            $code = "SUCCESS";
            return view('paymentSuccess');
            return response()->json(compact('code','transaction','timeline'));
        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function confirmGet(Request $request) {
        try {
//            dd($request);
            $transaction = Transaction::where('id',$request->transaction_id)->first();

            if ($transaction==null) {
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

            $product = Product::where('id',$transaction->product_id)
                ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                    'store_id', 'created_at', 'updated_at', 'deleted_at')
                ->with('store', 'store.user')
                ->first();

            $images = Product::where('id', $product->id)
                ->select('image1','image2','image3','image4','image5')
                ->first()
                ->toArray();

            $imArray = [];
            foreach ($images as $link) {
                if ($link!=null) {
                    array_push($imArray, compact('link'));
                }
            }
            $product->images = $imArray;
            $transaction->product = $product;

            $code = "SUCCESS";
            return view('paymentSuccess');
            return response()->json(compact('code','transaction','timeline'));
        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function confirmPayment(Request $request) {
        return view('confirmPayment');
    }

    public function getTransactionsByProduct(Request $request) {
        try {
            $transactions = Transaction::where('product_id',$request->product_id)
                ->with('user')
                ->get();

            foreach ($transactions as $transaction) {
                $product = Product::withTrashed()
                    ->where('id',$request->product_id)
                    ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                        'store_id', 'created_at', 'updated_at', 'deleted_at')
                    ->with('store', 'store.user')
                    ->first();

                $images = Product::where('id', $product->id)
                    ->select('image1','image2','image3','image4','image5')
                    ->first()
                    ->toArray();

                $imArray = [];
                foreach ($images as $link) {
                    if ($link!=null) {
                        array_push($imArray, compact('link'));
                    }
                }
                $product->images = $imArray;
                $transaction->product = $product;
            }

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
                ->get();

            foreach ($transactions as $transaction) {
                $product = Product::where('id',$transaction->product_id)
                    ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                        'store_id', 'created_at', 'updated_at', 'deleted_at')
                    ->with('store', 'store.user')
                    ->first();

                $images = Product::where('id', $product->id)
                    ->select('image1','image2','image3','image4','image5')
                    ->first()
                    ->toArray();

                $imArray = [];
                foreach ($images as $link) {
                    if ($link!=null) {
                        array_push($imArray, compact('link'));
                    }
                }
                $product->images = $imArray;
                $transaction->product = $product;
            }

            $code = "SUCCESS";
            return response()->json(compact('products','user','transactions','code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function getTransactionsByStore(Request $request) {
        try {
            $product_ids = Product::where('store_id',$request->store_id)
                ->select('id')
                ->get()
                ->toArray();

            $transactions = Transaction::whereIn('product_id',$product_ids)
                ->orderBy('id','desc')
                ->get();

            foreach ($transactions as $transaction) {
                $product = Product::where('id',$transaction->product_id)
                    ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                        'store_id', 'created_at', 'updated_at', 'deleted_at')
                    ->with('store', 'store.user')
                    ->first();

                $images = Product::where('id', $product->id)
                    ->select('image1','image2','image3','image4','image5')
                    ->first()
                    ->toArray();

                $imArray = [];
                foreach ($images as $link) {
                    if ($link!=null) {
                        array_push($imArray, compact('link'));
                    }
                }
                $product->images = $imArray;
                $transaction->product = $product;
            }

            $transaction_count = sizeof($transactions);
            $code = "SUCCESS";
            return response()->json(compact('transactions','transaction_count','code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function getTransactionSumByStore(Request $request) {
        try {
            $product_ids = Product::where('store_id',$request->store_id)
                ->select('id')
                ->get()
                ->toArray();

            $transactions = Transaction::whereIn('product_id',$product_ids)
                ->select('total')
                ->get();

            $total = 0;
            foreach ($transactions as $amount) {
                $total = $total + $amount->total;
            }

            $transaction_count = sizeof($transactions);

            $code = "SUCCESS";
            return response()->json(compact('transaction_count','total','code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function getTransactionById(Request $request) {
        try {
            $transaction = Transaction::where('id',$request->transaction_id)
                ->with('user')
                ->first();

            if ($transaction==null) {
                $code = "FAILED";
                $description = "Transaction not found";
                return response()->json(compact('code','description'));
            }

            $product = Product::where('id',$transaction->product_id)
                ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                    'store_id', 'created_at', 'updated_at', 'deleted_at')
                ->with('store', 'store.user')
                ->first();

            $images = Product::where('id', $product->id)
                ->select('image1','image2','image3','image4','image5')
                ->first()
                ->toArray();

            $imArray = [];
            foreach ($images as $link) {
                if ($link!=null) {
                    array_push($imArray, compact('link'));
                }
            }
            $product->images = $imArray;

            $transaction->product = $product;

            $timeline = Timeline::where('transaction_id',$request->transaction_id)->first();

            $code = "SUCCESS";
            return response()->json(compact('transaction','timeline','code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function getTransactionsByCategory(Request $request) {
        try {
            $product_ids = Product::where('category',$request->category)
                ->select('id')
                ->get()
                ->toArray();

            $transactions = Transaction::whereIn('product_id',$product_ids)
                ->get();

            foreach ($transactions as $transaction) {
                $product = Product::where('id',$transaction->product_id)
                    ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                        'store_id', 'created_at', 'updated_at', 'deleted_at')
                    ->with('store', 'store.user')
                    ->first();

                $images = Product::where('id', $product->id)
                    ->select('image1','image2','image3','image4','image5')
                    ->first()
                    ->toArray();

                $imArray = [];
                foreach ($images as $link) {
                    if ($link!=null) {
                        array_push($imArray, compact('link'));
                    }
                }
                $product->images = $imArray;
                $transaction->product = $product;
            }

            $transaction_count = sizeof($transactions);

            $code = "SUCCESS";
            return response()->json(compact('transactions','transaction_count','code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

}
