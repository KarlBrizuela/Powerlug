<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Policy;
use App\Models\InsuranceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        return view('pages.commission-form', compact('insuranceProviders', 'policies'));
    }

    /**
     * Store a newly created commission in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'policy_id' => 'required|exists:policies,id',
            'insurance_provider_id' => 'required|exists:insurance_providers,id',
            'policy_number' => 'required|string|max:255',
            'insured' => 'required|string|max:255',
            'term' => 'required|string|max:50',
            'gross_premium' => 'required|numeric|min:0',
            'net_premium' => 'required|numeric|min:0',
            'days_30' => 'nullable|numeric|min:0',
            'days_60' => 'nullable|numeric|min:0',
            'days_90' => 'nullable|numeric|min:0',
            'last_pdc_date' => 'nullable|date',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'payment_status' => 'required|in:pending,partial,paid',
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
        
        return view('pages.commission-form', compact('commission', 'insuranceProviders', 'policies'));
    }

    /**
     * Update the specified commission in storage.
     */
    public function update(Request $request, $id)
    {
        $commission = Commission::findOrFail($id);

        $validated = $request->validate([
            'policy_id' => 'required|exists:policies,id',
            'insurance_provider_id' => 'required|exists:insurance_providers,id',
            'policy_number' => 'required|string|max:255',
            'insured' => 'required|string|max:255',
            'term' => 'required|string|max:50',
            'gross_premium' => 'required|numeric|min:0',
            'net_premium' => 'required|numeric|min:0',
            'days_30' => 'nullable|numeric|min:0',
            'days_60' => 'nullable|numeric|min:0',
            'days_90' => 'nullable|numeric|min:0',
            'last_pdc_date' => 'nullable|date',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'payment_status' => 'required|in:pending,partial,paid',
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
            'term' => $this->calculateTerm($policy->start_date, $policy->end_date),
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
}
