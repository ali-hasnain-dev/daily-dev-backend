<?php

use App\Events\TestEvent;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/checkCredentials', [AuthController::class, 'checkCredentials']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/update/profile', [UserController::class, 'updateProfileImage']);

    Route::apiResource('post', PostController::class);
});

Route::post('/test/channel', function () {
    $post = Post::select('*')->with('user')->orderByDesc("id")->first();
    TestEvent::dispatch($post);
    return response()->json(['message' => 'Data sent to client successfully'], 200);
});
