<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Collection;
use App\Models\WalkIn;
use App\Models\Claim;

class CollectionController extends Controller
{
    public function create()
    {
        $clients = $this->syncAndGetClientsFromWalkinsAndClaims();
        return view('pages.collection-management', compact('clients'));
    }

    public function index()
    {
        $stats = [
            'total_amount' => Collection::sum('collection_amount'),
            'total_collections' => Collection::count(),
            'pending_collections' => Collection::where('collection_status', 'pending')->count(),
            'deposited_collections' => Collection::where('collection_status', 'deposited')->count()
        ];
        
        $collections = Collection::with('client')->latest()->paginate(10);
        $clients = $this->syncAndGetClientsFromWalkinsAndClaims();
        
        return view('pages.collection-info', compact('stats', 'collections', 'clients'));
    }

    public function edit(Collection $collection)
    {
        $clients = $this->syncAndGetClientsFromWalkinsAndClaims();
        return view('pages.collection-edit', compact('collection', 'clients'));
    }

    /**
     * Quick view for AJAX-loaded collection details used by the collection list modal.
     */
    public function quickView(Collection $collection)
    {
        return view('pages.partials.collection-details', compact('collection'));
    }

    /**
     * Create Client records for claim names that don't have a matching client yet.
     * Returns the filtered list of clients to display in the dropdown (only those from claims).
     */
    protected function syncAndGetClientsFromWalkinsAndClaims()
    {
        $createdClients = [];

        // Process claim client names only (exclude walk-ins)
        $claims = Claim::query()->select('id', 'client_name')->whereNotNull('client_name')->distinct()->get();
        foreach ($claims as $claim) {
            $name = trim($claim->client_name);
            if (empty($name)) {
                continue;
            }

            // Parse name
            $first = $name;
            $last = '';
            $parts = preg_split('/\s+/', $name);
            if (count($parts) > 1) {
                $first = array_shift($parts);
                $last = array_pop($parts);
            }

            // Check if client already exists
            $existing = Client::where('firstName', $first)->where('lastName', $last)->first();
            if (!$existing) {
                $uniqueSuffix = uniqid() . '-' . bin2hex(random_bytes(4));
                $client = Client::create([
                    'firstName' => $first,
                    'middleName' => implode(' ', $parts),
                    'lastName' => $last,
                    'email' => 'unknown+' . $uniqueSuffix . '@example.com',
                    'phone' => '00000000000',
                    'address' => $name,
                    'city' => 'Unknown',
                    'province' => 'Unknown',
                    'postalCode' => '0000',
                    'tin' => 'unknown',
                    'make_model' => 'Unknown',
                    'plate_no' => 'Unknown',
                    'model_year' => 2000,
                    'color' => 'Unknown',
                ]);
                if (!isset($createdClients[$client->id])) {
                    $createdClients[$client->id] = 'Claim';
                }
            } else {
                if (!isset($createdClients[$existing->id])) {
                    $createdClients[$existing->id] = 'Claim';
                }
            }
        }

        // Fetch clients and attach source information
        $clientIds = array_keys($createdClients);
        $clients = Client::whereIn('id', $clientIds)->orderBy('lastName')->orderBy('firstName')->get();
        
        foreach ($clients as $client) {
            $client->source = $createdClients[$client->id] ?? 'Unknown';
        }

        return $clients;
    }

    public function update(Request $request, Collection $collection)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'required|string|unique:collections,invoice_number,' . $collection->id,
            'collection_amount' => 'required|numeric|min:0',
            'loa' => 'nullable|string|max:255',
            'payment_method' => 'required|in:cash,check,bank_transfer',
            'collection_status' => 'required|in:deposited,pending,cleared,bounced,cash',
            'billing_status' => 'required|in:billed,pending,overdue',
            'collection_date' => 'required|date',
            'bank_name' => 'nullable|string'
        ]);

        $collection->update($validatedData);

        return redirect()
            ->route('collections.index')
            ->with('success', 'Collection record updated successfully.');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'required|string|unique:collections,invoice_number',
            'collection_amount' => 'required|numeric|min:0',
            'loa' => 'nullable|string|max:255',
            'payment_method' => 'required|in:cash,check,bank_transfer',
            'collection_status' => 'required|in:deposited,pending,cleared,bounced,cash',
            'billing_status' => 'required|in:billed,pending,overdue',
            'collection_date' => 'required|date',
            'bank_name' => 'nullable|string'
        ]);

        // Generate collection number
        $latestCollection = Collection::latest()->first();
        $lastNumber = $latestCollection ? intval(substr($latestCollection->collection_number, 4)) : 0;
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $validatedData['collection_number'] = 'COL-' . $newNumber;

        $collection = Collection::create($validatedData);

        return redirect()
            ->route('collections.index')
            ->with('success', 'Collection record created successfully.');
    }
}