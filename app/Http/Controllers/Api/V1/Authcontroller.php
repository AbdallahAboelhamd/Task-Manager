<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authcontroller extends Controller
{
    public function login(Request $request){
        $data = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        if(!Auth::attempt($data)){
            return response()->json([
                    "message" => "Data is not correct"
                    
            ],401);
        }
        $user = Auth::user();
        $token = $user->createToken('API-Token')->plainTextToken;

        return response()->json([
            "message" => "logged in successfully",
            "Data" => $user,
            "token" => $token
        ]);

    }
}
