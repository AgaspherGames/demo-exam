<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function signin(Request $request)
    {
        $data = $request->validate([
            "username" => ["required", "exists:users,username"],
            "password" => ["required",],
        ]);

        if (!auth()->attempt($data)) {
            return response([
                "status" => "invalid",
                "message" => "Wrong username or password"
            ], 401);
        }

        $user = User::where('username', $data['username'])->first();

        if ($user->tokens()->count()) {
            return response([
                "status" => "invalid",
                "message" => "Logout from last device"
            ], 401);
        }

        if ($user->ban_reason) {
            return response([
                "status" => "invalid",
                "message" => $user->ban_reason
            ], 401);
        }

        $user->last_login = now();
        $user->save();
        $token = $user->createToken('')->plainTextToken;

        return response([
            "status" => "success",
            "token" => $token,
            "username" => $user->username,
        ]);
    }
    public function signup(Request $request)
    {
        $data = $request->validate([
            "username" => ["required", "unique:users,username", "min:4", "max:60"],
            "password" => ["required","min:8",],
        ]);

        $data["password"] = bcrypt($data["password"]);

        $data["last_login"] = now();
        $user = User::create($data);

        $token = $user->createToken('')->plainTextToken;

        return response([
            "status" => "success",
            "token" => $token,
            "username" => $user->username,
        ]);
    }
    public function signout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response([
            "status" => "success",
        ]);
    }

    public function show(Request $request, string $username)
    {
        $user = User::where('username', $username)->first();

        return new UserResource($user);
    }
}
