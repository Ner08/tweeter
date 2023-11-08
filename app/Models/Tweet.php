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
    public function likes()
    {
        return $this->hasMany(Like::class, 'tweet_id');
    }
    public function parent()
    {
        return $this->belongsTo(Tweet::class, 'tweet_id');
    }
    public function children()
    {
        return $this->hasMany(Tweet::class, 'tweet_id');
    }
}

