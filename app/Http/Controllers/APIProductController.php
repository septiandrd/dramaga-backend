<?php

namespace App\Http\Controllers;

use App\Image;
use App\Product;
use Illuminate\Http\Request;

class APIProductController extends Controller
{
    public function getSuggestedProducts(Request $request) {
        try {
            $products = Product::inRandomOrder()->with('images')->take(5)->get();
            return response()->json(compact('products'));

        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }
}
