<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::withTrashed()->get();
        return view('admin.games', compact("games"));
    }
    public function show(string $slug)
    {
        $game = Game::withTrashed()->where('slug', $slug)->first();
        return view('admin.game', compact("game"));
    }
    public function destroy(string $slug)
    {
        $game = Game::withTrashed()->where('slug', $slug)->first();
        $game->delete();
        return redirect(route('games'));
    }

    public function clearScores(string $slug)
    {
        $game = Game::withTrashed()->where('slug', $slug)->first();
        $scores = Score::whereHas('version', function($q) use($game){
            $q->where('game_id', $game->id);
        })->delete();
        return back();
    }

    public function clearScore(string $id)
    {
        $score = Score::find($id)->delete();
        return back();
    }

    public function clearUserScore(string $slug, string $user_id)
    {
        $game = Game::withTrashed()->where('slug', $slug)->first();
        $scores = Score::whereHas('version', function($q) use($game){
            $q->where('game_id', $game->id);
        })->where('user_id', $user_id)->delete();
        return back();
    }
}
