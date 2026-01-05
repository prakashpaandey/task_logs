<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $client = Client::create([
            'name' => $request->name,
            'user_id' => auth()->id()
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Client created successfully.', 'client' => $client->load('user')]);
        }
        return back()->with('success', 'Client created successfully.');
    }

    public function update(Request $request, Client $client)
    {
        $this->authorizeUser($client);
        $request->validate(['name' => 'required|string|max:255']);
        $client->update($request->only('name'));

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Client updated successfully.', 'client' => $client->load('user')]);
        }
        return back()->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $this->authorizeUser($client);
        $client->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Client deleted successfully.']);
        }
        return redirect()->route('dashboard')->with('success', 'Client deleted successfully.');
    }

    protected function authorizeUser($model)
    {
        // All users are admins and can manage all data
        // if ($model->user_id !== auth()->id()) {
        //     abort(403);
        // }
    }
}
