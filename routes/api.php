<?php

use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Public Routes
Route::post('/users/login', [UserController::class, 'login']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/unauthenticated', [UserController::class,'unauthenticated'])->name('unauthenticated');

//Protected Routes

Route::group(['middleware'=> ['auth:sanctum']], function () {
    Route::post('/users/logout/{user}', [UserController::class, 'logout']);
//Put inside when frontend ready


});


Route::put('/users/{user}', [UserController::class, 'update']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::post('/users/{user}', [UserController::class, 'destroy']);

//CRUD Routes Tweets (index, show, store, update, destroy)
Route::apiResource("tweets", TweetController::class);


