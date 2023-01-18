<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('login', [App\Http\Controllers\UserController::class, 'login']);
Route::post('register', [App\Http\Controllers\UserController::class, 'register']);
Route::post('upload/{id}/{type}', [\App\Http\Controllers\UploadController::class,'upload']);
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('logout', [App\Http\Controllers\UserController::class, 'logout']);
    Route::post('me', [App\Http\Controllers\UserController::class, 'me']);
    Route::post('base64/{photo}', [\App\Http\Controllers\UploadController::class,'base64']);
    Route::apiResource('shops', \App\Http\Controllers\ShopController::class);
    Route::apiResource('users', \App\Http\Controllers\UserController::class);
    Route::apiResource('categories', \App\Http\Controllers\CategoryController::class);
    Route::post('shopStatusActive/{id}', [\App\Http\Controllers\ShopController::class,'shopStatusActive']);
});
