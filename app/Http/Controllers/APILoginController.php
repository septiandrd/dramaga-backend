<?php

namespace App\Http\Controllers;
use App\Store;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use JWTFactory;
use JWTAuth;
use App\User;

class APILoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 200);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        try {
            $user = User::where('email',$request->email)->first();
            $user->remember_token = $token;
            $user->save();
            $store = Store::where('user_id',$user->id)->get();

        } catch (JWTException $e) {
            return response()->json(['error' => 'invalid_credentials'], 200);
        }

        return response()->json(compact('token','user','store'),200);
    }
}