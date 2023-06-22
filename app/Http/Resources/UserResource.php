<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "username" => $this->username,
            "registeredTimestamp" =>  $this->created_at,
            "authoredGames" =>  UserGameResource::collection($this->games),
            "highscores" =>  UserScoreResource::collection($this->scores->sortByDesc('score')->unique('version.game_id'))
        ];
    }
}
