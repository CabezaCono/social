<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user_name' => $this->user->name,
            'user_avatar' => 'https://semantic-ui.com/images/wireframe/image.png',
            'likes_count' => $this->likesCount(),
            'is_liked' => $this->isLiked()
        ];
    }
}
