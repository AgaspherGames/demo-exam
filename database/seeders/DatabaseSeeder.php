<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Game;
use App\Models\Score;
use App\Models\User;
use App\Models\Version;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            GameSeeder::class,
            VersionSeeder::class,
            ScoreSeeder::class,
        ]);
    }
}

class UserSeeder extends Seeder{
    public function run(){
        User::create(
            [
                "username"=>"user1",
                "password"=>bcrypt("password1"),
                "last_login"=>now(),
            ]
        );
        User::create(
            [
                "username"=>"user2",
                "password"=>bcrypt("password2"),
                "last_login"=>now(),
            ]
        );
        User::create(
            [
                "username"=>"user3",
                "password"=>bcrypt("password3"),
                "last_login"=>now(),
            ]
        );
    }
}
class AdminSeeder extends Seeder{
    public function run(){
        Admin::create(
            [
                "username"=>"admin",
                "password"=>bcrypt("password"),
                "last_login"=>now(),
            ]
        );
        Admin::create(
            [
                "username"=>"admin2",
                "password"=>bcrypt("password2"),
                "last_login"=>now(),
            ]
        );
        Admin::create(
            [
                "username"=>"admin3",
                "password"=>bcrypt("password3"),
                "last_login"=>now(),
            ]
        );
    }
}
class GameSeeder extends Seeder{
    public function run(){
        Game::create(
            [
                "title"=>"Game 1",
                "description"=>"Beeajbdiwu vadu ivway pduwia tdftyw aibspidvuwty asd wasafafsf",
                "slug"=>"game-1",
                "user_id"=>1,
            ]
        );
        Game::create(
            [
                "title"=>"Game 2",
                "description"=>"Beeajbdiwu vadu ivway pduwia tdftyw aibspidvuwty asd wasafaakbdu ywcaytc do[wa tdcva sdankdsfssgeljkb fuiseygfiuaon sfiuygwe uygfsf",
                "slug"=>"game-2",
                "user_id"=>1,
            ]
        );
        Game::create(
            [
                "title"=>"Game 3",
                "description"=>"Beeajbdiwu vadu ivway pduwia tdBeeajbdiwu vadu ivway pduwia tdftyw aibspidvuwty asd wasafafsfBeeajbdiwu vadu ivway pduwia tdftyw aibspidvuwty asd wasafafsfftyw aibspidvuwty asd wasafafsf",
                "slug"=>"game-3",
                "user_id"=>2,
            ]
        );
    }
}
class VersionSeeder extends Seeder{
    public function run(){
        Version::create(
            [
                "game_id"=>1,
                "version"=>now(),
                "path"=>"/game-1/v1/as",
            ]
        );
        Version::create(
            [
                "game_id"=>1,
                "version"=>now(),
                "path"=>"/game-1/v2/as",
            ]
        );
        Version::create(
            [
                "game_id"=>2,
                "version"=>now(),
                "path"=>"/game-2/v1/as",
            ]
        );
    }
}
class ScoreSeeder extends Seeder{
    public function run(){
        Score::create(
            [
                "user_id"=>1,
                "version_id"=>1,
                "score"=>12,
            ]
        );
        Score::create(
            [
                "user_id"=>1,
                "version_id"=>2,
                "score"=>15,
            ]
        );
        Score::create(
            [
                "user_id"=>2,
                "version_id"=>1,
                "score"=>5,
            ]
        );
        Score::create(
            [
                "user_id"=>1,
                "version_id"=>3,
                "score"=>6,
            ]
        );
        Score::create(
            [
                "user_id"=>2,
                "version_id"=>3,
                "score"=>5,
            ]
        );
    }
}
