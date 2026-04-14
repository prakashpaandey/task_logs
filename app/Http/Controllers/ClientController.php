<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $request->validate([
            'name' => 'required|string|max:255',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id'
        ]);
        
        $client = Client::create([
            'name' => $request->name,
            'user_id' => auth()->id()
        ]);
        
        if ($request->has('user_ids')) {
            $client->users()->sync($request->user_ids);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Client created successfully.', 'client' => $client->load(['user', 'users'])]);
        }
        return back()->with('success', 'Client created successfully.');
    }

    public function update(Request $request, Client $client)
    {
        $this->authorizeAdmin();
        $request->validate([
            'name' => 'required|string|max:255',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id'
        ]);
        
        $client->update($request->only('name'));
        
        if ($request->has('user_ids')) {
            $client->users()->sync($request->user_ids);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Client updated successfully.', 'client' => $client->load(['user', 'users'])]);
        }
        return back()->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $this->authorizeAdmin();
        $client->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Client deleted successfully.']);
        }
        return redirect()->route('dashboard')->with('success', 'Client deleted successfully.');
    }

    protected function authorizeAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only Super Admins can manage clients.');
        }
    }
}
