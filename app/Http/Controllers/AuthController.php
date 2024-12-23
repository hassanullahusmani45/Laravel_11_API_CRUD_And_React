<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\error;
use function Pest\Laravel\json;

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


    public function login() {}



    public function logout()
    {
        return "logout";
    }
}
