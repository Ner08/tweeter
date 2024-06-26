<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TweetIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        // Format a string (How Long Since Created)
        $diff = now()->diffInDays(Carbon::parse($this->created_at));
        $diffStr = $diff . "d";

        if ($diff == 0) {
            $diff = now()->diffInHours(Carbon::parse($this->created_at));
            $diffStr = $diff . "h";
        }
        if ($diff == 0) {
            $diff = now()->diffInMinutes(Carbon::parse($this->created_at));
            $diffStr = $diff . "m";
        }
        if ($diff == 0) {
            $diff = now()->diffInSeconds(Carbon::parse($this->created_at));
            $diffStr = $diff . "s";
        }

        //Getting tweet_id
        $parentId = $this->parent !== null ? $this->parent->id : null;

        //Getting number of comments
        $numOfComments = $this->children()->count();

        return [
            'id' => $this->id,
            'message' => $this->message,
            'name' => $this->user->name,
            'userName' => $this->user->userName,
            'file' => $this->file,
            'user_id' => $this->user_id,
            'tweet_id' => $parentId,
            'share_url' => $this->share_url,
            'like' => $this->like,
            'numOfComments' => $numOfComments,
            'shares' => $this->shares,
            'views' => $this->views,
            'createdAgo' => $diffStr,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
