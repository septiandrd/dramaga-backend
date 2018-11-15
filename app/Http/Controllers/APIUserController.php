<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class APIUserController extends Controller
{
    public function getUserByRole(Request $request) {
        try {
            $users = User::where('role_id',$request->role_id)
                ->get();
            $user_count = sizeof($users);
            $code = "SUCCESS";
            return response()->json(compact('users','user_count','code'));
        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }

    public function getUserByGender(Request $request) {
        try {
            $users = User::where('gender',$request->gender)
                ->get();
            $user_count = sizeof($users);
            $code = "SUCCESS";
            return response()->json(compact('users','user_count','code'));
        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }
}
