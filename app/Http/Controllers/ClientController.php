<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.client-list'); // Use your actual view name
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // If you have a create form view, use it here
        // If not, create one or use a different approach
        return view('client-list.create');
        return view('client.create'); // This will still cause error if view doesn't exist
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Your store logic here
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'contact_number' => 'required|string',
            'address' => 'required|string',
            'active_status' => 'boolean',
        ]);

        // Save to database here
        // Client::create($validated);

        // return redirect()->route('client.index')
        //                 ->with('success', 'Client created successfully!');
    }

    // ... other methods (show, edit, update, destroy)
}