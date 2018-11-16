<?php

namespace App\Http\Controllers;

use App\Store;
use App\User;
use Illuminate\Http\Request;
use Mockery\Exception;
use Validator;

class APIStoreController extends Controller
{
    public function getAllStore(Request $request) {
        try {
            $stores = Store::get();
            $store_count = sizeof($stores);
            $code = "SUCCESS";
            return response()->json(compact('stores','store_count','code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function getStoresByLevel(Request $request) {
        try {
            $stores = Store::where('level',$request->level)->get();
            $store_count = sizeof($stores);
            $code = "SUCCESS";
            return response()->json(compact('stores','store_count','code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function getStoresByUser(Request $request) {
        try {
            $stores = Store::where('user_id',$request->user_id)->get();
            $store_count = sizeof($stores);
            $code = "SUCCESS";
            return response()->json(compact('stores','store_count','code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function getStoreLevelCount(Request $request) {
        try {
            $mikro = Store::where('level',1)->get();
            $mikro_count = sizeof($mikro);
            $kecil = Store::where('level',2)->get();
            $kecil_count = sizeof($kecil);
            $menengah = Store::where('level',3)->get();
            $menengah_count = sizeof($menengah);

            $code = "SUCCESS";
            return response()->json(compact('mikro_count','kecil_count','menengah_count','code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }

    public function saveStore(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'address' => 'required',
                'user_id' => 'required',
                'level' => 'required|integer|in:1,2,3',
            ]);

            $user = User::where('id',$request->user_id)->first();

            if ($user->role_id!=2) {
                $code = "FAILED";
                $description = "User not a seller";
                return response()->json(compact('code','description'));
            }

            if ($validator->fails() or $user==null) {
                if($user==null) {
                    $user = "User not found";
                    return response()->json(compact('user'),401);
                }
                return response()->json($validator->errors(),401);
            }

            $store = new Store;
            $store->name = $request->get('name');
            $store->description = $request->get('description');
            $store->address = $request->get('address');
            $store->user_id = $request->get('user_id');
            $store->level = $request->get('level');
            $store->save();

            $code = "SUCCESS";
            return response()->json(compact('code'));

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }
}
