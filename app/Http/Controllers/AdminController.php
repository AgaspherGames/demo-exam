<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $admins = Admin::all();

        return view('admin.index', compact("admins"));
    }
    public function loginView(){
        return view('admin.login');
    }
    public function login(Request $request){

        $data = $request->validate([
            "username"=>["required", "exists:admins,username"],
            "password"=>["required"],
        ]);

        if (auth('admin')->attempt($data)){
            $request->session()->regenerate();
            return redirect(route('admins'));
        }
        return back();

    }
}
