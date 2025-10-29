<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        // Validate incoming data
        $data = $request->validate([
            "name"=> "required",
            "password"=> "required"
        ]);

        // Attempt to authenticate the user
        if (!Auth::attempt($data)){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // $request->session()->regenerate();

        return response()->json([
            'message' => 'Login successful',
            'user' => Auth::user()], 200);
    }

    public function logout(Request $request){
        Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return response()->json(['message' => 'Logout successful'], 200);
    }

    public function register(Request $request){
        // Validate incoming data
        $data = $request->validate([
            "name" => ["required", Rule::unique("users", "name")],
            "email"=> ["required", "email", Rule::unique("users", "email")],
            "password"=> "required"
        ]);

        // Hash password
        $data["password"] = bcrypt($data["password"]);

        // Store new user in database
        $user = User::create($data);

        return response()->json([
            'user' => $user,
        ], 200);
    }
}
