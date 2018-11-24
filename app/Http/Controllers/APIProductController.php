<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use PhpParser\Node\Expr\Cast\Object_;
use function Sodium\add;
use Validator;
use App\Image;
use App\Product;
use App\Store;
use Illuminate\Http\Request;

class APIProductController extends Controller
{
    public function getAllProducts(Request $request)
    {
        try {
            $products = Product::with('store')
                ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                    'store_id', 'created_at', 'updated_at', 'deleted_at')
                ->get();

            foreach ($products as $product) {
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
            }

            $product_count = sizeof($products);
            $code = "SUCCESS";
            return response()->json(compact( 'products', 'product_count', 'code'));
        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code', 'description'));
        }
    }

    public function getProductsByStore(Request $request)
    {
        try {
            $store = Store::where('id', $request->store_id)
                ->with('user')
                ->first();
            $products = Product::where('store_id', $request->store_id)
                ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                    'store_id', 'created_at', 'updated_at', 'deleted_at')
                ->get();

            foreach ($products as $product) {
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
            }

            $product_count = sizeof($products);
            $code = "SUCCESS";
            return response()->json(compact('store', 'products', 'product_count', 'code'));
        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code', 'description'));
        }
    }

    public function getProductDetails(Request $request)
    {
        try {
            $product = Product::where('id', $request->id)
                ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                    'store_id', 'created_at', 'updated_at', 'deleted_at')
                ->with('store', 'store.user')
                ->first();

            if ($product==null) {
                $code = "FAILED";
                $description = "Product not found";
                return response()->json(compact('code', 'description'));
            }

            $images = Product::where('id', $request->id)
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

            $code = "SUCCESS";
            return response()->json(compact('product', 'code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code', 'description'));
        }
    }

    public function getSuggestedProducts(Request $request)
    {
        try {
            $products = Product::where('store_id', 12)
                ->select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                    'store_id', 'created_at', 'updated_at', 'deleted_at')
                ->with('store', 'store.user')
                ->get();
            foreach ($products as $product) {
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
            }

            $product_count = sizeof($products);
//            $products = Product::inRandomOrder()
//                ->select('id','name','original_price','discounted_price','stock','store_id')
//                ->with('images','store')
//                ->take(5)
//                ->get();
            $code = "SUCCESS";
            return response()->json(compact('products','product_count', 'code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code', 'description'));
        }
    }

    public function saveProduct(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'original_price' => 'required',
                'stock' => 'required',
                'category' => 'required',
                'store_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 401);
            }

            $store = Store::where('id', $request->store_id)->first();


            if ($store == null) {
                $store = "Store not found";
                return response()->json(compact('store'), 401);
            }

            $product = new Product;
            $product->name = $request->get('name');
            $product->description = $request->get('description');
            $product->original_price = $request->get('original_price');
            $product->discounted_price = $request->get('discounted_price');
            $product->stock = $request->get('stock');
            $product->category = $request->get('category');
            $product->store_id = $request->get('store_id');
            $product->image1 = $request->get('image1');
            $product->image2 = $request->get('image2');
            $product->image3 = $request->get('image3');
            $product->image4 = $request->get('image4');
            $product->image5 = $request->get('image5');
            $product->save();

            $code = "SUCCESS";
            return response()->json(compact('code', 'product'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code', 'description'));
        }
    }

    public function saveImage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 401);
            }

            $path = $request->file('image')->store(
                'public/product_img'
            );

            $image = new Image;
            $image->link = "https://serbalokal.com/api/product/img?path=" . $path;
            $image->save();

            $code = "SUCCESS";
            return response()->json(compact('code', 'image'));
        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code', 'description'));
        }
    }

    public function getImage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'path' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 401);
            }

            $path = $request->query('path');
            $imgpath = storage_path() . '/app/' . $path;

            if (!File::exists($imgpath)) abort(404);

            $image = File::get($imgpath);
            $type = File::mimeType($imgpath);
            $response = Response::make($image, 200);
            $response->header("Content-Type", $type);

            return $response;
        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code', 'description'));
        }
    }

    public function deleteProduct(Request $request)
    {
        try {
            $product = Product::where('id', $request->product_id)->withTrashed()->get();

            if (sizeof($product) == 0) {
                $code = "FAILED";
                $description = "Product not found";
                return response()->json(compact('code', 'description'));
            } else {
                Product::where('id', $request->product_id)->delete();
            }

            $code = "SUCCESS";
            return response()->json(compact('code'));
        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code', 'description'));
        }
    }

    public function getProductsByTransactionCount(Request $request)
    {
        try {
            $products = Product::
//                ->get();
                select('id', 'name', 'description', 'original_price', 'discounted_price', 'stock', 'category',
                    'store_id', 'created_at', 'updated_at', 'deleted_at')
                ->with('store', 'store.user')
                ->withCount('transactions')
                ->orderBy('transactions_count', 'desc')
                ->get();

            foreach ($products as $product) {
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
            }

            $product_count = sizeof($products);

            $code = "SUCCESS";
            return response()->json(compact('products','product_count', 'code'));
        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code', 'description'));
        }
    }
}
