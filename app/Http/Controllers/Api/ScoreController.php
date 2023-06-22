<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScoreResource;
use App\Models\Game;
use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function getByGame(string $slug)
    {
        $game = Game::where('slug', $slug)->first();

        return response(
            [
                "scores" => ScoreResource::collection($game->scores->sortByDesc('score')->unique('user_id'))
            ]
        );
    }
    public function store(Request $request, string $slug)
    {
        $game = Game::where('slug', $slug)->first();

        $data = $request->validate([
            "score" => ["required", "numeric"],
        ]);

        $data['user_id'] = $request->user()->id;
        $data['version_id'] = $game->lastVersion->id;

        $score = Score::create($data);

        return response(
            [
                "status" => "success"
            ],
            201
        );
    }
}
