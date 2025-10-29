<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function getAllUsers() {
        // Retrieve all users for admin
        return response()->json(User::all(), 200);
    }

    public function updateUserRole(Request $request) {
        // Validate request data
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role' => ['required', 'string', 'in:user,admin,manager'],
        ]);

        // Fetch and update user
        $userToUpdate = User::findOrFail($data['user_id']);
        $userToUpdate->update(['role'=>$data['role']]);

        return response()->json([
            'message' =>" User {$userToUpdate->name} promoted to {$data['role']}",
        ], 200);
    }
}
