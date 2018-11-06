<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class APIRegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required|min:8',
            'phone' => 'required',
            'gender' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),401);
        }
        User::create([
            'role_id' => $request->get('role_id'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'gender' => $request->get('gender'),
        ]);
        $user = User::first();
        $token = JWTAuth::fromUser($user);

        return Response::json(compact('token'));
    }
}