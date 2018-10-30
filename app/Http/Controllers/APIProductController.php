<?php

namespace App\Http\Controllers;

use App\Image;
use App\Product;
use App\Store;
use Illuminate\Http\Request;

class APIProductController extends Controller
{
    public function getProductDetails(Request $request) {
        try {
            $products = Product::where('id',$request->id)
                ->with('images','store','store.user')
                ->first();
            return response()->json(compact('products'));

        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }

    public function getSuggestedProducts(Request $request) {
        try {
            $products = Product::inRandomOrder()
                ->select('id','name','original_price','discounted_price','stock','store_id')
                ->with('images','store')
                ->take(5)
                ->get();
            return response()->json(compact('products'));

        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }
}
