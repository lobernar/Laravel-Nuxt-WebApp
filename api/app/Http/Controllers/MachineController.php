<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MachineController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        $machines = Machine::accessibleBy($user)->get();
        return response()->json($machines);
    }

    public function show(Machine $machine, Request $request) {
        $this->authorize('read', $machine);
        return response()->json($machine);
    }

    public function action(Machine $machine, Request $request) {
        $this->authorize('control', $machine);
        // perform some action on the machine
        $action = $request->validate(['action' => 'required|string']);
        // ... action logic here ...
        return response()->json(['status' => 'ok', 'action' => $action['action']]);
    }
}
