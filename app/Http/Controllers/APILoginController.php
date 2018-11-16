<?php

namespace App\Http\Controllers;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

            $pass = $request->password;
            $pass_e = bcrypt($request->password);


            $user = User::where('email',$request->email)
                ->first();

            if ($user!=null) {
                if (Hash::check($request->password,$user->password)) {
                    $token = JWTAuth::fromUser($user);
                    $user->remember_token = $token;
                    $user->save();
                    $code = "SUCCESS";
                    $description = "OK";
                    if ($user->role_id==2) {
                        $store = Store::where('user_id',$user->id)->get();
                        return response()->json(compact('user','store','token','code', 'description'),200);
                    }
                    return response()->json(compact('user','token','code', 'description'),200);
                }

                $code = "FAILED";
                $description = "PASSWORD MISSMATCH";
                return response()->json(compact('code', 'description'),200);
            } else {
                $code = "FAILED";
                $description = "USER NOT FOUND";
                return response()->json(compact('code', 'description'),200);
            }

        } catch (Exception $exception) {
            $code = "FAILED";
            $description = $exception;
            return response()->json(compact('code','description'));
        }
    }
}