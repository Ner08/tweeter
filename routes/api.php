<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Public Routes
Route::post('/users/login', [UserController::class, 'login']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/unauthenticated', [UserController::class, 'unauthenticated'])->name('unauthenticated');

//Protected Routes

Route::group(['middleware' => ['auth:sanctum']], function () {

    //User
    Route::get('/users/logout/{user}', [UserController::class, 'logout']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::post('/users/{user}', [UserController::class, 'destroy']);
    /* Route::get('/users/tokenAuth', [UserController::class, 'checkToken']); */

    //Tweets
    //CRUD Routes Tweets (index, show, store, update, destroy)
    Route::apiResource("tweets", TweetController::class);
    Route::get('/tweets/comments/{tweet}', [TweetController::class,'getChildTweets']);

    //Likes
    Route::post('/like',[LikeController::class,'store']);
    Route::delete('/unlike',[LikeController::class,'delete']);
});






