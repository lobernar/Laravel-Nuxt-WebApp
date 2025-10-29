<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUser(Request $request){
        return response()->json(Auth::user(), 200);
    }

    public function update(Request $request) {
        $data = $request->validate([
            "name" => "",
            "email"=> "email",
            "password"=> "",
        ]);

        if(isset($data["password"])) {
            // Hash password
            $data["password"] = bcrypt($data["password"]);
        }

        $user = Auth::user();
        $user->update($data);
        // $request->session()->regenerate();
        
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }

    public function delete(Request $request) {
        $user = Auth::user();
        // Auth::logout();
        $user->delete();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
