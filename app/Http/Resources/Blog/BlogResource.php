<?php

namespace App\Http\Resources\Blog;

use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Image\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
