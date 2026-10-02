<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = auth()->user()->clients()->withCount('services')->latest()->paginate(15);

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'email'   => 'nullable|email|max:255',
            'address' => 'nullable|string|max:1000',
        ]);

        $request->user()->clients()->create($data);

        return redirect()->route('clients.index')->with('ok', 'Client add ho gaya.');
    }

    public function destroy(Client $client)
    {
        abort_unless($client->user_id === auth()->id(), 403);
        $client->delete();

        return back()->with('ok', 'Client deleted successfully along with all associated services.');
    }
}
