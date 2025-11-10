<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    public function index()
    {
        return view('pages.audit-trail');
    }
}