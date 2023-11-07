<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetIndexResource;
use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    //Get All Tweets
    public function index()
    {
        return TweetIndexResource::collection(Tweet::latest()->paginate(10));
    }

    //Get Tweet With Specific ID
    public function show(Tweet $tweet)
    {
        return new TweetIndexResource($tweet);
    }

    //Store Tweet
    public function store(Request $request)
    {
        $formFields = $request->validate([
            "message" => "required_without:file",
            "shareUrl" => "url",
            "user_id" => ['required','integer'],
            "file"=>'mimes:jpeg,jpg,png|max:5000'
        ]);

        //Check if request has an image - if it has store it in the public imgs folder
        if ($request->hasFile('file')) {
            $formFields['file'] = $request->file('file')->store('files', 'public');
        }

        $tweet = Tweet::create($formFields);
        $tweet = $tweet->refresh();

        return response()->json(['status' => 'success', 'tweet' => new TweetIndexResource($tweet)], 200);
    }

    //Update Tweet
    public function update(Request $request, Tweet $tweet)
    {
        $formFields = $request->validate([
            "message" => "required",
            "shareUrl" => "url",
            "user_id" => ['required', 'integer']
        ]);

        //Check if request has an image - if it has store it in the public imgs folder
        if ($request->hasFile('file')) {
            $formFields['file'] = $request->file('file')->store('files', 'public');
        }

        $tweet->update($formFields);

        return response()->json(['status' => 'success'], 200);
    }

    //Delete Tweet
    public function destroy(Tweet $tweet)
    {
        $tweet->delete();

        return response()->json(['status' => 'success'], 200);
    }
}
