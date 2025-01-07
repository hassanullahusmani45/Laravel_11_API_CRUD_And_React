<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\PersonalAccessToken;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::apiResource("posts", PostController::class)->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);
Route::post('/logout', [AuthController::class, "logout"]);



Route::post('/verify-token', function (Request $request) {
    $token = $request->token;

    $accessToken = PersonalAccessToken::findToken($token);

    if (!$accessToken) {
        return response()->json([
            'status' => 'error'
        ]);
    }

    $user = $accessToken->tokenable;

    return response()->json([
        'status' => 'success',
        'user' => $user,
    ]);
});
