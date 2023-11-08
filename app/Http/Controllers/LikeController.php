<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $formField = $request->validate([
            "user_id" => "integer",
            "tweet_id" => "integer"
        ]);

        $alreadyLiked = !is_null(Like::where("user_id", '=', $formField['user_id'])->where("tweet_id", "=", $formField["tweet_id"])->first());
        if ($alreadyLiked) {
            return response()->json(["status" => "failed", "message" => "user already liked this post"], 404);
        } else {
            Like::create($formField);
            return response()->json(["status" => "success", "message" => "like created"], 201);
        }
    }
    public function delete(Request $request)
    {
        $formField = $request->validate([
            "user_id" => "integer",
            "tweet_id" => "integer"
        ]);

        $exists = !is_null(Like::where("user_id", '=', $formField['user_id'])->where("tweet_id", "=", $formField["tweet_id"])->first());
        if ($exists) {
            Like::where("user_id", "=", $formField["user_id"])->where("tweet_id", "=", $formField["tweet_id"])->delete();
            return response()->json(["status" => "success", "message" => "like deleted"], 200);
        } else {
            return response()->json(["status" => "failed", "message" => "the like does not exist"], 404);
        }
    }
}
