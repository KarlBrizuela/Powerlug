<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Collection;
use App\Models\WalkIn;
use App\Models\Claim;
use App\Models\Policy;
use App\Exports\CollectionsExport;
use Maatwebsite\Excel\Facades\Excel;

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
     * Returns all available clients, including those from claims.
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

        // Fetch ALL clients, ordered alphabetically, with source info for those from claims
        $clients = Client::orderBy('lastName')->orderBy('firstName')->get();
        
        foreach ($clients as $client) {
            $client->source = $createdClients[$client->id] ?? 'Manual';
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

    public function getClaimData($clientId)
    {
        try {
            $client = Client::find($clientId);
            if (!$client) {
                return response()->json([
                    'policy_number' => '',
                    'claim_number' => '',
                    'loa_amount' => 0
                ], 200);
            }

            // Get all policies for this client
            $policies = Policy::where('client_id', $clientId)->pluck('id')->toArray();
            
            if (empty($policies)) {
                return response()->json([
                    'policy_number' => '',
                    'claim_number' => '',
                    'loa_amount' => 0
                ], 200);
            }

            // Find the latest claim for any of the client's policies
            $claim = Claim::whereIn('policy_id', $policies)
                ->latest()
                ->first();

            if ($claim) {
                return response()->json([
                    'policy_number' => $claim->policy_number ?? '',
                    'claim_number' => $claim->claim_number ?? '',
                    'loa_amount' => (float) ($claim->loa_amount ?? 0)
                ], 200);
            }

            return response()->json([
                'policy_number' => '',
                'claim_number' => '',
                'loa_amount' => 0
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'policy_number' => '',
                'claim_number' => '',
                'loa_amount' => 0
            ], 200);
        }
    }

    public function export()
    {
        return Excel::download(new CollectionsExport, 'collections-' . date('Y-m-d-H-i-s') . '.xlsx');
    }
}