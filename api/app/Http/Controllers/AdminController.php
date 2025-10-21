<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function getAllUsers() {
        // Retrieve all users for admin
        return response()->json(User::all(), 200);
    }
}
