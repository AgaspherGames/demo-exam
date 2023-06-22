<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameIndexResource;
use App\Http\Resources\GameSlugResource;
use App\Models\Game;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query('size', 10);
        $sortBy = $request->query('sortBy', 'title');
        $sortDir = $request->query('sortDir', 'asc');

        $games = Game::query();

        if ($sortBy == 'title') {
            $games->orderBy('title', $sortDir);
        }
        if ($sortBy == 'popular') {
            $games->withCount('scores')->orderBy('scores_count', $sortDir);
        }
        if ($sortBy == 'uploaddate') {
            $games->withMax('versions', 'version')->orderBy('versions_max_version', $sortDir);
        }

        $games = $games->paginate($size);

        return response([
            "page" => $games->currentPage(),
            "size" => $size,
            "totalElements" => $games->total(),
            "content" => GameIndexResource::collection($games->items())
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => ['required', "min:3", "max:60"],
            "description" => ['required', "min:0", "max:200"],
        ]);

        $data["user_id"] = $request->user()->id;
        $data["slug"] = Str::slug($data['title']);

        $game = Game::create($data);
        return response([
            "status" => "success",
            "slug" => $game->slug
        ]);
    }

    public function show(string $slug)
    {
        $game = Game::where('slug', $slug)->first();

        if (!$game) return response([]);
        // if (!$game->versions->count()) return response([]);

        return response(
            new GameSlugResource($game)
        );
    }

    public function upload(Request $request, string $slug)
    {
        $request->validate([
            "zipfile" => 'required'
        ]);

        $game = Game::where('slug', $slug)->first();

        if ($request->user()->id != $game->user_id) {
            return response([
                "status" => "invalid",
                "message" => "User is not author of the game"
            ], 400);
        }

        $version = Version::create([
            "game_id" => $game->id,
            "version" => now(),
            "path" => "/$game->slug/temp/index.html",
        ]);

        $dir_path = $game->slug . '/';
        $file = $request->file('zipfile');
        $zip = new ZipArchive();
        $file_new_path = $file->storeAs($dir_path . $version->id, 'zipname', 'public');
        $zipFile = $zip->open(Storage::disk('public')->path($file_new_path));
        if ($zipFile === TRUE) {
            $zip->extractTo(Storage::disk('public')->path($dir_path . $version->id));
            $zip->close();
        } else {
            return response([
                "status" => "invalid",
                "message" => "ZIP file extraction fails"
            ], 400);
        }
        $url = Storage::url($dir_path . $version->id);

        if (file_exists(Storage::disk('public')->path($dir_path . $version->id . "/thumbnail.png"))) {
            $game->thumbnail = url($url . "/thumbnail.png");
            $game->save();
        }
        $version->path = url($url . "/index.html");
        $version->save();
        return response($version);
    }

    public function edit(Request $request, string $slug)
    {
        $game = Game::where('slug', $slug)->first();

        if ($request->user()->id != $game->user_id) {
            return response([
                "status" => "forbidden",
                "message" => "You are not the game author"
            ], 403);
        }

        $data = $request->validate([
            "title" => ["min:3", "max:60"],
            "description" => ["min:0", "max:200"],
        ]);

        if (isset($data["title"])) {
            $game->title = $data["title"];
        }
        if (isset($data["description"])) {
            $game->description = $data["description"];
        }

        $game->save();
        return ["status" => "success"];
    }

    public function destroy(Request $request, string $slug)
    {
        $game = Game::where('slug', $slug)->first();

        if ($request->user()->id != $game->user_id) {
            return response([
                "status" => "forbidden",
                "message" => "You are not the game author"
            ], 403);
        }
        $game->delete();

        return response([], 204);
    }
}
