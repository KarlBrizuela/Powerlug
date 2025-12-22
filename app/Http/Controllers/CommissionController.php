<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Policy;
use App\Models\InsuranceProvider;
use App\Models\Claim;
use App\Models\WalkIn;
use App\Exports\CommissionsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CommissionController extends Controller
{
    /**
     * Display a listing of commissions.
     */
    public function index(Request $request)
    {
        $query = Commission::with(['insuranceProvider', 'policy'])->orderBy('created_at', 'desc');

        // Apply filters if provided
        if ($request->has('insurance_provider_id') && $request->insurance_provider_id) {
            $query->where('insurance_provider_id', $request->insurance_provider_id);
        }

        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $commissions = $query->paginate(50)->withQueryString();
        
        // Get insurance providers for filter dropdown
        $insuranceProviders = InsuranceProvider::orderBy('name')->get();
        
        // Get available policies (that don't have commissions yet)
        $availablePolicies = Policy::with('insuranceProvider')
            ->whereNotIn('id', Commission::pluck('policy_id'))
            ->orderBy('policy_number')
            ->get();

        return view('pages.commission', compact('commissions', 'insuranceProviders', 'availablePolicies'));
    }

    /**
     * Show the form for creating a new commission.
     */
    public function create()
    {
        $insuranceProviders = InsuranceProvider::orderBy('name')->get();
        $policies = Policy::with('insuranceProvider')->orderBy('policy_number')->get();
        $claims = Claim::select('id', 'client_name', 'loa_amount', 'insurance_provider_id', 'policy_number')->orderBy('client_name')->get();
        $walkIns = WalkIn::select('id', 'insured_name', 'plate_number', 'premium')->orderBy('insured_name')->get();
        $services = \App\Models\Service::orderBy('name')->get();
        
        return view('pages.commission-form', compact('insuranceProviders', 'policies', 'claims', 'walkIns', 'services'));
    }

    /**
     * Store a newly created commission in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'policy_id' => 'nullable|exists:policies,id',
            'claim_id' => 'nullable|exists:claims,id',
            'walk_in_id' => 'nullable|exists:walk_ins,id',
            'insurance_provider_id' => 'required|exists:insurance_providers,id',
            'policy_number' => 'required|string|max:255',
            'insured' => 'required|string|max:255',
            'gross_premium' => 'required|numeric|min:0',
            'net_premium' => 'required|numeric|min:0',
            'loa' => 'nullable|string|max:255',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'payment_status' => 'required|in:pending,partial,paid',
            'agent' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        // Calculate commission amount
        $validated['commission_amount'] = ($validated['net_premium'] * $validated['commission_rate']) / 100;
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        $commission = Commission::create($validated);

        return redirect()->route('commission.index')
            ->with('success', 'Commission created successfully.');
    }

    /**
     * Display the specified commission.
     */
    public function show($id)
    {
        $commission = Commission::with(['insuranceProvider', 'policy', 'createdBy', 'updatedBy'])->findOrFail($id);
        
        return view('pages.commission-show', compact('commission'));
    }

    /**
     * Show the form for editing the specified commission.
     */
    public function edit($id)
    {
        $commission = Commission::findOrFail($id);
        $insuranceProviders = InsuranceProvider::orderBy('name')->get();
        $policies = Policy::with('insuranceProvider')->orderBy('policy_number')->get();
        $claims = Claim::select('id', 'client_name', 'loa_amount', 'insurance_provider_id', 'policy_number')->orderBy('client_name')->get();
        $walkIns = WalkIn::select('id', 'insured_name', 'plate_number', 'premium')->orderBy('insured_name')->get();
        $services = \App\Models\Service::orderBy('name')->get();
        
        return view('pages.commission-form', compact('commission', 'insuranceProviders', 'policies', 'claims', 'walkIns', 'services'));
    }

    /**
     * Update the specified commission in storage.
     */
    public function update(Request $request, $id)
    {
        $commission = Commission::findOrFail($id);

        $validated = $request->validate([
            'policy_id' => 'nullable|exists:policies,id',
            'claim_id' => 'nullable|exists:claims,id',
            'walk_in_id' => 'nullable|exists:walk_ins,id',
            'insurance_provider_id' => 'required|exists:insurance_providers,id',
            'policy_number' => 'required|string|max:255',
            'insured' => 'required|string|max:255',
            'gross_premium' => 'required|numeric|min:0',
            'net_premium' => 'required|numeric|min:0',
            'loa' => 'nullable|string|max:255',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'payment_status' => 'required|in:pending,partial,paid',
            'agent' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        // Recalculate commission amount
        $validated['commission_amount'] = ($validated['net_premium'] * $validated['commission_rate']) / 100;
        $validated['updated_by'] = Auth::id();

        $commission->update($validated);

        return redirect()->route('commission.index')
            ->with('success', 'Commission updated successfully.');
    }

    /**
     * Remove the specified commission from storage.
     */
    public function destroy($id)
    {
        $commission = Commission::findOrFail($id);
        $commission->delete();

        return redirect()->route('commission.index')
            ->with('success', 'Commission deleted successfully.');
    }

    /**
     * Get commission details via AJAX.
     */
    public function getDetails($id)
    {
        $commission = Commission::with(['insuranceProvider', 'policy', 'createdBy', 'updatedBy'])->findOrFail($id);
        
        return response()->json($commission);
    }

    /**
     * Update commission status - Super Admin only.
     */
    public function updateStatus(Request $request, $id)
    {
        // Check if user is super admin
        if (Auth::user()->position !== 'superadmin') {
            return response()->json(['message' => 'Unauthorized. Only super admins can change commission status.'], 403);
        }

        $commission = Commission::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|string|in:PENDING,CLEARED,TRANSFERRED',
            'type' => 'required|string|in:Policy,Claim,Walk-In'
        ]);

        // Validate status based on commission type
        if ($validated['type'] === 'Policy' && !in_array($validated['status'], ['PENDING', 'CLEARED'])) {
            return response()->json(['message' => 'Invalid status for Policy commission.'], 422);
        }

        if ($validated['type'] === 'Claim' && !in_array($validated['status'], ['PENDING', 'TRANSFERRED'])) {
            return response()->json(['message' => 'Invalid status for Claim commission.'], 422);
        }

        // Update the commission status
        $commission->update([
            'status' => $validated['status'],
            'updated_by' => Auth::id()
        ]);

        return response()->json(['message' => 'Commission status updated successfully.', 'status' => $validated['status']]);
    }

    /**
     * Auto-fill commission data from policy.
     */
    public function getPolicyData($policyId)
    {
        $policy = Policy::with('insuranceProvider', 'client')->findOrFail($policyId);
        
        return response()->json([
            'insurance_provider_id' => $policy->insurance_provider_id,
            'insurance_provider_name' => $policy->insuranceProvider->name ?? 'N/A',
            'policy_number' => $policy->policy_number,
            'insured' => $policy->client_name ?? $policy->client->name ?? 'N/A',
            'gross_premium' => $policy->premium ?? 0,
            'net_premium' => $policy->premium ?? 0,
        ]);
    }

    /**
     * Calculate term from start and end dates.
     */
    private function calculateTerm($startDate, $endDate)
    {
        if (!$startDate || !$endDate) {
            return 'N/A';
        }

        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        $months = $start->diffInMonths($end);

        return $months . ' Months';
    }

    /**
     * Export commissions to Excel.
     */
    public function export(Request $request)
    {
        $query = Commission::with(['insuranceProvider', 'policy', 'claim'])->orderBy('created_at', 'desc');

        // Apply same filters as index
        if ($request->has('insurance_provider_id') && $request->insurance_provider_id) {
            $query->where('insurance_provider_id', $request->insurance_provider_id);
        }

        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $commissions = $query->get();

        $filename = 'commissions_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new CommissionsExport($commissions), $filename);
    }
}
