<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'file', 'user_id', 'tweet_id', 'shareUrl', 'like', 'numOfComments', 'shares', 'views'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function parentTweet()
    {
        return $this->belongsTo(Tweet::class, 'tweet_id');
    }
}

