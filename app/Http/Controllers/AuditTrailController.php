<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Policy;

class AuditTrailController extends Controller
{
    public function index(Request $request)
    {
        $policy = null;
        $policyId = $request->query('policy_id');
        if ($policyId) {
            $policy = Policy::with('createdBy', 'updatedBy')->find($policyId);
        }

        // Load audit entries, optionally filter by policy id when provided
        $auditsQuery = \App\Models\AuditTrail::with('user')->orderBy('created_at', 'desc');
        if ($policyId) {
            // audit description contains "Policy #<id>" as created by the observer
            $auditsQuery->where('module', 'Policy')->where('description', 'like', "%#{$policyId}%");
        }

        $audits = $auditsQuery->paginate(50);

        return view('pages.audit-trail', compact('policy', 'audits'));
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