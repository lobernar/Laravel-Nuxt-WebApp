<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function login(Request $request){
        // Validate incoming data
        $data = $request->validate([
            "loginname"=> "required",
            "loginpassword"=> "required"
        ]);

        // Attempt to authenticate the user
        if (auth()->guard()->attempt(["name" => $data["loginname"], 
            "password" => $data["loginpassword"]])) {
            $request->session()->regenerate();
        }
        return redirect("/");
    }

    public function logout(){
        auth()->guard()->logout();
        return redirect("/");
    }

    public function register(Request $request){
        // Validate incoming data
        $data = $request->validate([
            "email"=> ["required", "email", Rule::unique("users", "email")],
            "password"=> "required",
            "name" => ["required", Rule::unique("users", "name")]
        ]);

        // Hash password
        $data["password"] = bcrypt($data["password"]);

        // Store new user in database
        $user = User::create($data);
        auth()->guard()->login($user);
        return redirect("/");
    }
}
