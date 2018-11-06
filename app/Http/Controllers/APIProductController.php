<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use Validator;
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
            $code = "SUCCESS";
            return response()->json(compact('products','code'));

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
            $code = "SUCCESS";
            return response()->json(compact('products','code'));

        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }

    public function saveProduct(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'original_price' => 'required',
                'stock' => 'required',
                'category' => 'required',
                'store_id' => 'required',
            ]);

            $store = Store::where('id',$request->store_id)->first();

            if ($validator->fails() or $store==null) {
                if($store==null) {
                    $store = "Store not found";
                    return response()->json('store',401);
                }
                return response()->json($validator->errors(),401);
            }

            $product = new Product;
            $product->name = $request->get('name');
            $product->description = $request->get('description');
            $product->original_price = $request->get('original_price');
            $product->discounted_price = $request->get('discounted_price');
            $product->stock = $request->get('stock');
            $product->category = $request->get('category');
            $product->store_id = $request->get('store_id');
            $product->save();


            $counter = 0;
            for ($i=0; $i<5; $i++) {
                if($request->hasFile('image'.$i)) {
                    $path = $request->file('image'.$i)->store(
                        'public/product_img/' . $request->get('store_id')
                    );
                    $imSave = new Image;
                    $imSave->product_id = $product->id;
                    $imSave->link = $path;
                    $imSave->save();
                    $counter++;
                }

            }

            $code = "SUCCESS";
            return response()->json(compact('code'));

        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }

    public function getImage(Request $request) {
        try {
            $path = $request->query('path');
            $imgpath = storage_path() . '/app/public/' . $path;

            if(!File::exists($imgpath)) abort(404);

            $image = File::get($imgpath);
            $type = File::mimeType($imgpath);
            $response = Response::make($image, 200);
            $response->header("Content-Type", $type);

            return $response;
        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }
}
