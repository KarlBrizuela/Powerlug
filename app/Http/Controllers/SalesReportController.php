<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WalkIn;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'check.position:superadmin']);
    }

    public function index()
    {
        // Get total sales for walk-ins
        $walkInSales = WalkIn::sum('amount');

        // You can add more sales calculations here for insurance policies and claims
        // once those models are created

        return view('reports.sales', compact('walkInSales'));
    }
}