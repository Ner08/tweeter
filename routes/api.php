<?php

use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//CRUD Routes Tweets (index, show, store, update, destroy)
Route::apiResource("tweets", TweetController::class);

//CRUD Routes Users (index, show, store, update, destroy)
Route::apiResource("users", UserController::class);
