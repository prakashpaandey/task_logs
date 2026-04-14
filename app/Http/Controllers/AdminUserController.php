<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        $users = User::all();
        return response()->json(['success' => true, 'users' => $users]);
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:super_admin,developer',
        ]);

        $generatedPassword = Str::random(12);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($generatedPassword),
            'role' => $request->role,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'User created successfully.', 
            'user' => $user,
            'generated_password' => $generatedPassword // Show once to Admin
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeAdmin();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:super_admin,developer',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update($request->only('name', 'email', 'role', 'status'));

        return response()->json(['success' => true, 'message' => 'User updated successfully.', 'user' => $user]);
    }

    public function destroy(User $user)
    {
        $this->authorizeAdmin();
        
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'You cannot delete yourself.'], 403);
        }

        $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    }

    protected function authorizeAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
