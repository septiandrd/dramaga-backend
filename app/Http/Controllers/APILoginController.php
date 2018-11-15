<?php

namespace App\Http\Controllers;
use App\Store;
use Illuminate\Http\Request;
use Mockery\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use JWTFactory;
use App\User;

class APILoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password'=> 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $pass = bcrypt($request->password);

            $user = User::where('email',$request->email)
                ->where('password',bcrypt($request->get('password')))
                ->first();

//            $token = JWTAuth::fromUser($user);
//            $user->remember_token = $token;
//            $user->save();
//            $store = Store::where('user_id',$user->id)->get();

            $code = "SUCCESS";
            $description = "OK";
            return response()->json(compact('user','pass','code', 'description'),200);

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
//
//        $credentials = $request->only('email', 'password');
//
//
//        try {
//            if (! $token = JWTAuth::attempt($credentials)) {
//                return response()->json(['error' => 'invalid_credentials'], 200);
//            }
//        } catch (JWTException $e) {
//            return response()->json(['error' => 'could_not_create_token'], 500);
//        }
//
//        try {
//            $user = User::where('email',$request->email)->first();
//            $user->remember_token = $token;
//            $user->save();
//            $store = Store::where('user_id',$user->id)->get();
//
//        } catch (JWTException $e) {
//            return response()->json(['error' => 'invalid_credentials'], 200);
//        }
//
//        return response()->json(compact('token','user','store'),200);
    }
}