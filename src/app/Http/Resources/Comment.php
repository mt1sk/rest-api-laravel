<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
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
            'text' => $this->text,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_at_human' => $this->created_at->diffForHumans(),
            'user' => new User($this->whenLoaded('user')),
        ];
    }
}
