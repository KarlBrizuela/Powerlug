<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function create()
    {
        $clients = [];
        return view('pages.collection-management', compact('clients'));
    }

    public function index()
    {
        $stats = [
            'total_amount' => 0,
            'total_collections' => 0,
            'pending_collections' => 0,
            'deposited_collections' => 0
        ];
        
        $collections = []; // Empty array for now
        $clients = []; // Empty array for clients filter
        
        return view('pages.collection-info', compact('stats', 'collections', 'clients'));
    }
}