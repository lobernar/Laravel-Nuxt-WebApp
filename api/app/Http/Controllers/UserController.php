<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{

    public function login(Request $request){
        // Validate incoming data
        $data = $request->validate([
            "loginname"=> "required",
            "loginpassword"=> "required"
        ]);

        // Attempt to authenticate the user
        if (auth()->guard()->attempt([
            "name" => $data["loginname"], 
            "password" => $data["loginpassword"]
            ])) {
                $user = User::where('name', $request['loginname'])->firstOrFail();

                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                    ]);
        }

        return response()->json([
        'message' => 'Login FAILED',
        'data' => $request->all(),
        ]);
    }

    public function logout(){
        auth()->guard()->logout();
        return redirect("/");
    }

    public function register(Request $request){
        // Validate incoming data
        $data = $request->validate([
            "regemail"=> ["required", "email", Rule::unique("users", "email")],
            "regpassword"=> "required",
            "regname" => ["required", Rule::unique("users", "name")]
        ]);

        // Hash password
        $data["regpassword"] = bcrypt($data["regpassword"]);

        // Store new user in database
        $user = User::create([
            'name' => $data["regname"],
            'email' => $data["regemail"],
            'password' => $data["regpassword"]
        ]);
        $token = $user->createToken('MyToken')->plainTextToken;
        //auth()->guard()->login($user);
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully.',
            'token' => $token,
            'user' => $user,
        ]);
    }
}
