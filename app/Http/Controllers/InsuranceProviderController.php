<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InsuranceProviderController extends Controller
{
    public function index()
{
    // Create dummy data for viewing
    $providers = collect([
        (object)[
            'id' => 1,
            'code' => 'HGI-001',
            'name' => 'Standard Insurance',
            'contact_person' => 'John Smith',
            'contact_phone' => '(555) 123-4567',
            'formatted_commission_rate' => '15%',
            'active_policies_count' => 25,
            'is_active' => true
        ],
        (object)[
            'id' => 2,
            'code' => 'SLI-002', 
            'name' => 'Cocogen Insurance',
            'contact_person' => 'Sarah Johnson',
            'contact_phone' => '(555) 987-6543',
            'formatted_commission_rate' => '12%',
            'active_policies_count' => 18,
            'is_active' => true
        ]
    ]);

    return view('pages.insurance-provider-list', compact('providers'));
}

    public function create()
    {
        return view('pages.new-insuranceprovider'); // Your actual file name
    }

    // ... rest of your methods
}