<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\error;

class AuthController extends Controller
{


    public function register(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|min:3|max:255",
            "email" => "required|email|min:3|max:255",
            "password" => "required|min:5|max:10"
        ]);

        $user = User::create($validatedData);
        $token = $user->createToken($request->name);
        return [
            "user_api_token" => $token->plainTextToken,
            "user" => $user
        ];
    }


    public function login(Request $request)
    {
        $validatedData = $request->validate([
            "email" => "required|email|min:3|max:255",
            "password" => "required|min:5|max:10"
        ]);

        $user = User::where("email", $validatedData["email"])->first();

        if (!$user) {
            return ["error" => "The email is incorrect."];
        } elseif (!Hash::check($request->password, $user->password)) {
            return ["error" => "The password is not mutch try agin."];
        } else {
            $token = $user->createToken($user->name);
            return [
                "user_api_token" => $token->plainTextToken,
                "user" => $user
            ];
        }
    }



    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return ["message" => "you are logouted successfully!"];
        } catch (\Exception $error) {
            return ["error" => "the tonken is incorect!"];
        }
    }
}
