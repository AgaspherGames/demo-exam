<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserGameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "slug"=> $this->slug,
            "title"=> $this->title,
            "description"=> $this->description,
            "thumbnail"=> $this->thumbnail,
        ];
    }
}