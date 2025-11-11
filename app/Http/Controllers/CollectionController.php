<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Collection;

class CollectionController extends Controller
{
    public function create()
    {
        $clients = Client::orderBy('lastName')->orderBy('firstName')->get();
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
        $clients = Client::orderBy('lastName')->orderBy('firstName')->get();
        
        return view('pages.collection-info', compact('stats', 'collections', 'clients'));
    }

    public function edit(Collection $collection)
    {
        $clients = Client::orderBy('lastName')->orderBy('firstName')->get();
        return view('pages.collection-edit', compact('collection', 'clients'));
    }

    public function update(Request $request, Collection $collection)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'required|string|unique:collections,invoice_number,' . $collection->id,
            'collection_amount' => 'required|numeric|min:0',
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