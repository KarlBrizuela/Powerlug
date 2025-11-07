<?php

namespace App\Http\Controllers;

use App\Models\WalkIn;
use Illuminate\Http\Request;

class WalkInController extends Controller
{
    public function index()
    {
        $walkIns = WalkIn::latest()->paginate(10); // or whatever pagination you prefer
        
        return view('pages.walk-in', compact('walkIns'));
    }

    // Your other methods (create, store, show, edit, update, destroy) here...
}