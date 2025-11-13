<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Policy;

class AuditTrailController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $module = $request->query('module');
        $recordId = $request->query('record_id');
        $action = $request->query('action');
        $userId = $request->query('user_id');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        // Build query
        $auditsQuery = \App\Models\AuditTrail::with('user')->orderBy('created_at', 'desc');

        // Apply filters
        if ($module) {
            $auditsQuery->where('module', $module);
        }
        
        if ($recordId) {
            $auditsQuery->where('record_id', $recordId);
        }
        
        if ($action) {
            $auditsQuery->where('action', $action);
        }
        
        if ($userId) {
            $auditsQuery->where('user_id', $userId);
        }
        
        if ($dateFrom) {
            $auditsQuery->whereDate('created_at', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $auditsQuery->whereDate('created_at', '<=', $dateTo);
        }

        $audits = $auditsQuery->paginate(50)->withQueryString();

        // Get distinct modules for filter dropdown
        $modules = \App\Models\AuditTrail::distinct()->pluck('module')->sort();
        
        // Get distinct actions for filter dropdown
        $actions = \App\Models\AuditTrail::distinct()->pluck('action')->sort();
        
        // Get users for filter dropdown
        $users = \App\Models\User::orderBy('name')->get();

        return view('pages.audit-trail', compact('audits', 'modules', 'actions', 'users'));
    }

    public function show($id)
    {
        $audit = \App\Models\AuditTrail::with('user')->findOrFail($id);
        return view('pages.audit-details', compact('audit'));
    }

    public function destroy($id)
    {
        $audit = \App\Models\AuditTrail::findOrFail($id);
        $audit->delete();
        return redirect()->route('audit-trail.index')->with('success', 'Audit entry deleted');
    }

    public function clear(Request $request)
    {
        // Truncate the audit trail table (careful in production)
        \App\Models\AuditTrail::query()->delete();
        return redirect()->route('audit-trail.index')->with('success', 'All audit logs cleared');
    }
}