<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users', compact("users"));
    }
    public function show(string $username)
    {
        $user = User::where('username', $username)->first();
        return view('admin.user', compact("user"));
    }

    public function ban(Request $request, string $username)
    {
        $data = $request->validate([
            "ban_reason"=>"required"
        ]);
        $user = User::where('username', $username)->first();
        $user->ban_reason = $data['ban_reason'];
        $user->save();
        return redirect(route('users'));
    }
}
