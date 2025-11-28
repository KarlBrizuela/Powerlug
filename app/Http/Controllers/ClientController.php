<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('pages.client-list', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.new-client');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:clients',
            'phone' => 'required|string|size:11',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postalCode' => 'required|string|size:4',
            'tin' => 'required|string|max:255',
            'make_model' => 'required|string|max:255',
            'plate_no' => 'required|string|max:255',
            'model_year' => 'required|integer|min:1900|max:2100',
            'color' => 'required|string|max:255',
        ]);

        Client::create($validatedData);

        return redirect()->route('clients.index')
                        ->with('success', 'Client created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('pages.edit-client', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'required|string|size:11',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postalCode' => 'required|string|size:4',
            'tin' => 'required|string|max:255',
            'make_model' => 'required|string|max:255',
            'plate_no' => 'required|string|max:255',
            'model_year' => 'required|integer|min:1900|max:2100',
            'color' => 'required|string|max:255',
        ]);

        $client->update($validatedData);

        return redirect()->route('clients.index')
                        ->with('success', 'Client updated successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('pages.client-show', compact('client'));
    }
}