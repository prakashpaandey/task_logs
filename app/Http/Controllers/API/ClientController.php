<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        return response()->json(Client::where('user_id', auth()->id())->get());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $client = Client::create([
            'name' => $request->name,
            'user_id' => auth()->id() ?? $request->user_id, // Fallback for manual testing if auth not set
        ]);

        return response()->json($client, 201);
    }

    public function show(Client $client)
    {
        if ($client->user_id !== auth()->id() && auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($client);
    }

    public function update(Request $request, Client $client)
    {
        if ($client->user_id !== auth()->id() && auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $client->update($request->only('name'));
        return response()->json($client);
    }

    public function destroy(Client $client)
    {
        if ($client->user_id !== auth()->id() && auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $client->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
