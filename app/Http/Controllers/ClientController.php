<?php

namespace App\Http\Controllers;

use App\Exports\ClientsExport;
use App\Models\Client;
use App\Models\Policy;
use App\Models\WalkIn;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
     * Export clients to Excel.
     */
    public function export()
    {
        return Excel::download(new ClientsExport, 'clients-' . date('Y-m-d-H-i-s') . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.client-create');
    }

    /**
     * Show the quick client form (for policies/walk-ins)
     */
    public function quickForm()
    {
        // Get clients from policies
        $policyClients = Policy::select(
            'client_id',
            \DB::raw("CONCAT(TRIM(CONCAT(c.firstName, ' ', COALESCE(c.middleName, ''), ' ', c.lastName)), ' - Policy') as display_text")
        )
        ->join('clients as c', 'policies.client_id', '=', 'c.id')
        ->where('client_id', '!=', null)
        ->distinct()
        ->get();

        // Get policies without registered clients
        $policiesWithoutClients = Policy::select(
            \DB::raw("CONCAT(client_name, ' - Policy') as display_text")
        )
        ->where('client_id', '=', null)
        ->where('client_name', '!=', null)
        ->distinct()
        ->get();

        // Get walk-ins
        $walkInClients = WalkIn::select(
            \DB::raw("CONCAT(insured_name, ' - WalkIn') as display_text")
        )
        ->where('insured_name', '!=', null)
        ->distinct()
        ->get();

        // Get full client details for policy clients
        $clientIds = $policyClients->pluck('client_id')->toArray();
        $clients = Client::whereIn('id', $clientIds)
            ->select('id', 'firstName', 'middleName', 'lastName', 'email', 'phone')
            ->orderBy('firstName')
            ->get();

        // Add display text to each client
        $displayMap = $policyClients->pluck('display_text', 'client_id')->toArray();
        foreach ($clients as $client) {
            $client->display_text = $displayMap[$client->id] ?? trim($client->firstName . ' ' . $client->middleName . ' ' . $client->lastName);
        }

        // Add policies without clients with their display text
        foreach ($policiesWithoutClients as $policy) {
            $policy->id = null;
            $policy->firstName = $policy->display_text;
            $policy->middleName = '';
            $policy->lastName = '';
            $policy->email = '';
            $policy->phone = '';
        }

        // Add walk-in records with their display text
        foreach ($walkInClients as $walkin) {
            $walkin->id = null;
            $walkin->firstName = $walkin->display_text;
            $walkin->middleName = '';
            $walkin->lastName = '';
            $walkin->email = '';
            $walkin->phone = '';
        }

        // Merge all: policy clients + policies without clients + walk-in records
        $allClients = $clients->concat($policiesWithoutClients)->concat($walkInClients);

        // Sort by display_text
        $allClients = $allClients->sortBy('display_text')->values();

        // Get only clients created through the quick client form (those with empty address/city/province)
        $quickFormClients = Client::where('address', '')
            ->orWhere('address', null)
            ->orderBy('firstName')
            ->orderBy('lastName')
            ->get();

        return view('pages.client-form', [
            'existingClients' => $allClients,
            'allClients' => $quickFormClients
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if this is a quick form submission (with fullName) or full form (with firstName, lastName)
        $isQuickForm = $request->filled('fullName') && !$request->filled('firstName');

        if ($isQuickForm) {
            // Validation for quick client form
            $validatedData = $request->validate([
                'fullName' => 'required|string|max:255',
                'email' => 'required|email|unique:clients',
                'phone' => 'required|string|size:11',
                'tin' => 'required|string|max:255',
                'make_model' => 'required|string|max:255',
                'plate_no' => 'required|array|min:1',
                'plate_no.*' => 'required|string|max:255',
                'model_year' => 'required|integer|min:1900|max:2100',
                'color' => 'required|string|max:255',
            ]);

            // Parse full name into firstName and lastName
            $nameParts = explode(' ', trim($validatedData['fullName']), 2);
            $validatedData['firstName'] = $nameParts[0];
            $validatedData['lastName'] = $nameParts[1] ?? $nameParts[0];
            unset($validatedData['fullName']);

            // Set default values for address fields
            $validatedData['address'] = '';
            $validatedData['city'] = '';
            $validatedData['province'] = '';
            $validatedData['postalCode'] = '';
        } else {
            // Validation for full client form
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
                'plate_no' => 'required|array|min:1',
                'plate_no.*' => 'required|string|max:255',
                'model_year' => 'required|integer|min:1900|max:2100',
                'color' => 'required|string|max:255',
            ]);
        }

        // Store plate numbers as comma-separated string
        $validatedData['plate_no'] = implode(',', $validatedData['plate_no']);

        $client = Client::create($validatedData);

        // If AJAX request, return JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Client created successfully',
                'client' => $client
            ]);
        }

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