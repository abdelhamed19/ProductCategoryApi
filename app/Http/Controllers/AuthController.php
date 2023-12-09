<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => ["required", "string"],
            "email"=>["required", "email","unique:users,email"],
            "password" => ["required", "confirmed","string"]
        ]);

        $user = User::create(
            [
                "name" =>  $request->name,
                "email" =>  $request->email,
                "password" => Hash::make( $request->password)]
        );

        $token = $user->createToken('RegisterToken')->plainTextToken;
        return response()->json(['token' => $token,"user-info"=>$user], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email"=>["required", "email",],
            "password" => ["required","string"]
        ]);

        $user=User::where("email",$request->email)->first();

        if(!$user || !Hash::check($request->password,$user->password))
        {
            return response()->json(["message"=>"Invalid Credentials"],401);
        }
        $token = $user->createToken('RegisterToken')->plainTextToken;
        return response()->json(['token' => $token,"user-info"=>$user], 201);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
