<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\Client;
use App\Models\InsuranceProvider;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PolicyController extends Controller
{
    /**
     * Display a listing of policies.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Policy::with('client', 'insuranceProvider', 'createdBy');

        // Apply date filters if provided
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $policies = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('pages.policies.index', compact('policies'));
    }

    /**
     * Show the form for creating a new policy.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Load clients for the searchable dropdown
        $clients = Client::orderBy('firstName')->orderBy('lastName')->get();
        
        // Load insurance providers needed by the form
        $insuranceProviders = InsuranceProvider::all();

        // Load active freebies for the freebie select
        $freebies = \App\Models\Freebie::where('is_active', true)->orderBy('name')->get();

        // Load services to populate the Walk-in "Services Availed" dropdown/checkboxes
        $services = Service::orderBy('name')->get();

        return view('pages.policy', compact('clients', 'insuranceProviders', 'freebies', 'services'));
    }

    /**
     * Store a newly created policy in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    // Check if user is submitting policy details or walk-in details
    $hasPolicyData = $request->filled('insurance_provider_id') || 
                         $request->filled('issue_date') || 
                         $request->filled('coverage_from') || 
                         $request->filled('coverage_to') ||
                         $request->filled('chassis_number');
        
        $hasWalkinData = $request->filled('walkin_date') || 
                         $request->filled('estimate_amount') || 
                         $request->filled('size') ||
                         $request->filled('rate') ||
                         $request->filled('walkin_payment');

        $validated = $request->validate([
            // Primary Information
            'client_name' => 'nullable|string',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
            'contact_number' => 'nullable|string',
            
            // Vehicle Information
            'make_model' => 'nullable|string',
            'plate_number' => 'nullable|string',
            'model_year' => 'nullable|string',
            'color' => 'nullable|string',
            
            // Policy Details - At least one is required if policy type is selected
            // policy_number will be auto-assigned when omitted
            'policy_number' => 'nullable|string|unique:policies,policy_number',
            'client_id' => 'nullable|exists:clients,id',
            'insurance_provider_id' => 'nullable|exists:insurance_providers,id',
            'insurance_provider' => 'nullable|string',
            'issue_date' => 'nullable|date',
            'coverage_from' => 'nullable|date',
            'coverage_to' => 'nullable|date',
            'chassis_number' => 'nullable|string',
            'engine_number' => 'nullable|string',
            'mv_file_number' => 'nullable|string',
            'mortgage' => 'nullable|string',
            'freebie' => 'nullable|string',
            'policy_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            
            // Walk-in Details - At least one is required if walk-in type is selected
            'walkin_date' => 'nullable|date',
            'walkin_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'estimate_amount' => 'nullable|numeric|min:0',
            'size' => 'nullable|string',
            'services' => 'nullable|array',
            'service_payment_dues' => 'nullable|array',
            'rate' => 'nullable|numeric|min:0',
            'walkin_payment' => 'nullable|numeric|min:0',
            
            // Additional Payment Information
            'payment_terms' => 'nullable|string',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|in:Cash,Transfer,PDC,Cancelled',
            'bank_transfer' => 'nullable|string',
            'bank_transfer_other' => 'nullable|string',
            'bank_transfer_other' => 'nullable|string',
            'additional_freebie' => 'nullable|string',
            'reference_number' => 'nullable|string',
            
            // Premium Summary
            'coverage_amount' => 'nullable|numeric|min:0',
            'premium' => 'nullable|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'documentary_stamp_tax' => 'nullable|numeric|min:0',
            'local_gov_tax' => 'nullable|numeric|min:0',
            'amount_due' => 'nullable|numeric|min:0',
            'coc_vp' => 'nullable|numeric|min:0',
            'premium_remarks' => 'nullable|string',
            
            // Status Information
            'policy_type' => 'nullable|in:individual,family,corporate',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'nullable|in:active,inactive,expired,cancelled',
            'billing_status' => 'nullable|in:paid,unpaid,partial',
            'remarks' => 'nullable|string',
        ]);

        // Validate that at least policy details OR walk-in details are provided
        if (!$hasPolicyData && !$hasWalkinData) {
            return back()->withErrors([
                'details' => 'Please fill in either Policy Details or Walk-in Details (or both).'
            ])->withInput();
        }

        $validated['created_by'] = auth()->id();

        // If no policy_number provided, give a temporary unique value so DB constraints are satisfied
        $providedPolicyNumber = $validated['policy_number'] ?? null;
        if (empty($providedPolicyNumber)) {
            $validated['policy_number'] = 'TEMP-' . uniqid();
        }

        // Create the policy
        // If user selected a provider id, also store the provider code into the insurance_provider column
        if (!empty($validated['insurance_provider_id'])) {
            $prov = InsuranceProvider::find($validated['insurance_provider_id']);
            if ($prov) {
                $validated['insurance_provider'] = $prov->code;
            }
        }

        // If bank_transfer was set to OTHER, replace with manual value if provided
        if ($request->input('bank_transfer') === 'OTHER' && $request->filled('bank_transfer_other')) {
            $validated['bank_transfer'] = $request->input('bank_transfer_other');
        }

        // Ensure DB non-nullable columns have safe defaults or are mapped correctly
        // coverage_amount and premium are non-nullable in the migration, default to 0 when omitted
        if (!isset($validated['coverage_amount']) || $validated['coverage_amount'] === null) {
            $validated['coverage_amount'] = 0.00;
        }
        if (!isset($validated['premium']) || $validated['premium'] === null) {
            $validated['premium'] = 0.00;
        }

        // Map coverage_from/coverage_to to start_date/end_date used by the DB schema
        if (!empty($validated['coverage_from'])) {
            $validated['start_date'] = $validated['coverage_from'];
        }
        if (!empty($validated['coverage_to'])) {
            $validated['end_date'] = $validated['coverage_to'];
        }

        // Ensure required DB columns start_date/end_date are set even for walk-in only submissions.
        // Preference: coverage_from/coverage_to -> walkin_date -> today
        $today = now()->toDateString();
        if (empty($validated['start_date'])) {
            $validated['start_date'] = $validated['coverage_from'] ?? $validated['walkin_date'] ?? $today;
        }
        if (empty($validated['end_date'])) {
            $validated['end_date'] = $validated['coverage_to'] ?? $validated['start_date'] ?? $today;
        }

        // Handle file upload if provided
        if ($request->hasFile('policy_file')) {
            $validated['policy_file'] = $request->file('policy_file')->store('policies', 'public');
        }

        $policy = Policy::create($validated);

        // If the policy number wasn't provided by user, set it to the auto-increment id (or any desired format)
        if (empty($providedPolicyNumber)) {
            // Option: use numeric id directly or prefix like POL-<id>
            $policy->policy_number = $policy->id; // or: 'POL-' . $policy->id
            $policy->save();
        }

        return redirect()->route('policies.index')->with('success', 'Policy created successfully');
    }

    /**
     * Display the specified policy.
     *
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function show(Policy $policy)
    {
        $policy->load('client', 'insuranceProvider', 'createdBy', 'updatedBy');

        return view('pages.policies.show', compact('policy'));
    }

    /**
     * Show the form for editing the specified policy.
     *
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function edit(Policy $policy)
    {
        // Load clients for the searchable dropdown
        $clients = Client::orderBy('firstName')->orderBy('lastName')->get();
        
        // Load insurance providers
        $insuranceProviders = InsuranceProvider::all();

        // Load active freebies for the freebie select
        $freebies = \App\Models\Freebie::where('is_active', true)->orderBy('name')->get();

        // Load services for the edit form
        $services = Service::orderBy('name')->get();

        return view('pages.policies.edit', compact('policy', 'clients', 'insuranceProviders', 'freebies', 'services'));
    }

    /**
     * Update the specified policy in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Policy $policy)
    {
        // Check if user is submitting policy details or walk-in details
        $hasPolicyData = $request->filled('insurance_provider') || 
                         $request->filled('issue_date') || 
                         $request->filled('coverage_from') || 
                         $request->filled('coverage_to') ||
                         $request->filled('chassis_number');
        
        $hasWalkinData = $request->filled('walkin_date') || 
                         $request->filled('estimate_amount') || 
                         $request->filled('size') ||
                         $request->filled('rate') ||
                         $request->filled('walkin_payment');

        $validated = $request->validate([
            // Primary Information
            'client_name' => 'nullable|string',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
            'contact_number' => 'nullable|string',
            
            // Vehicle Information
            'make_model' => 'nullable|string',
            'plate_number' => 'nullable|string',
            'model_year' => 'nullable|string',
            'color' => 'nullable|string',
            
            // Policy Details
            // Allow nullable on update; if omitted we won't overwrite existing value
            'policy_number' => 'nullable|string|unique:policies,policy_number,' . $policy->id,
            'client_id' => 'nullable|exists:clients,id',
            'insurance_provider_id' => 'nullable|exists:insurance_providers,id',
            'insurance_provider' => 'nullable|string',
            'issue_date' => 'nullable|date',
            'coverage_from' => 'nullable|date',
            'coverage_to' => 'nullable|date',
            'chassis_number' => 'nullable|string',
            'engine_number' => 'nullable|string',
            'mv_file_number' => 'nullable|string',
            'mortgage' => 'nullable|string',
            'freebie' => 'nullable|string',
            'policy_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            
            // Walk-in Details
            'walkin_date' => 'nullable|date',
            'walkin_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'estimate_amount' => 'nullable|numeric|min:0',
            'size' => 'nullable|string',
            'services' => 'nullable|array',
            'service_payment_dues' => 'nullable|array',
            'rate' => 'nullable|numeric|min:0',
            'walkin_payment' => 'nullable|numeric|min:0',
            
            // Additional Payment Information
            'payment_terms' => 'nullable|string',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|in:Cash,Transfer,PDC,Cancelled',
            'bank_transfer' => 'nullable|string',
            'additional_freebie' => 'nullable|string',
            'reference_number' => 'nullable|string',
            
            // Premium Summary
            'coverage_amount' => 'nullable|numeric|min:0',
            'premium' => 'nullable|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'documentary_stamp_tax' => 'nullable|numeric|min:0',
            'local_gov_tax' => 'nullable|numeric|min:0',
            'amount_due' => 'nullable|numeric|min:0',
            'coc_vp' => 'nullable|numeric|min:0',
            'premium_remarks' => 'nullable|string',
            
            // Status Information
            'policy_type' => 'nullable|in:individual,family,corporate',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'nullable|in:active,inactive,expired,cancelled',
            'billing_status' => 'nullable|in:paid,unpaid,partial',
            'remarks' => 'nullable|string',
        ]);

        // Validate that at least policy details OR walk-in details are provided
        if (!$hasPolicyData && !$hasWalkinData) {
            return back()->withErrors([
                'details' => 'Please fill in either Policy Details or Walk-in Details (or both).'
            ])->withInput();
        }

        // If user selected a provider id, also store the provider code into the insurance_provider column
        if (!empty($validated['insurance_provider_id'])) {
            $prov = InsuranceProvider::find($validated['insurance_provider_id']);
            if ($prov) {
                $validated['insurance_provider'] = $prov->code;
            }
        }

        // If bank_transfer was set to OTHER, replace with manual value if provided
        if ($request->input('bank_transfer') === 'OTHER' && $request->filled('bank_transfer_other')) {
            $validated['bank_transfer'] = $request->input('bank_transfer_other');
        }

        // Map coverage_from/coverage_to to start_date/end_date for database compatibility
        if (isset($validated['coverage_from'])) {
            $validated['start_date'] = $validated['coverage_from'];
        }
        if (isset($validated['coverage_to'])) {
            $validated['end_date'] = $validated['coverage_to'];
        }

        $validated['updated_by'] = auth()->id();

        // Handle file upload if provided
        if ($request->hasFile('policy_file')) {
            // Delete old file if it exists
            if ($policy->policy_file) {
                Storage::disk('public')->delete($policy->policy_file);
            }
            $validated['policy_file'] = $request->file('policy_file')->store('policies', 'public');
        }

        $policy->update($validated);

        return redirect()->route('policies.index')->with('success', 'Policy updated successfully');
    }

    /**
     * Remove the specified policy from storage.
     *
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Policy $policy)
    {
        $policy->delete();

        return redirect()->route('policies.index')->with('success', 'Policy deleted successfully');
    }

    /**
     * Show the installment page for a policy.
     *
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function installment(Policy $policy)
    {
        // Load installments for display
        $installments = $policy->installments()->orderBy('payment_date', 'desc')->get();

        return view('pages.policies.installment', compact('policy', 'installments'));
    }

    /**
     * Display all installments for a policy.
     *
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function listInstallments(Policy $policy)
    {
        $installments = $policy->installments()->orderBy('payment_date', 'desc')->paginate(20);

        return view('pages.policies.installments-list', compact('policy', 'installments'));
    }

    /**
     * Store installment payment records for a policy.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function storeInstallment(Request $request, Policy $policy)
    {
        $validated = $request->validate([
            'installments' => 'required|array|min:1',
            'installments.*.amount' => 'required|numeric|min:0.01',
            'installments.*.date' => 'required|date',
            'installments.*.method' => 'required|in:Cash,Check,Transfer,Online',
            'installments.*.reference' => 'nullable|string',
            'installments.*.remarks' => 'nullable|string',
        ]);
        // Persist each installment and calculate total
        $totalPaid = 0;
        foreach ($validated['installments'] as $inst) {
            $amount = $inst['amount'];
            $totalPaid += $amount;

            \App\Models\Installment::create([
                'policy_id' => $policy->id,
                'amount' => $amount,
                'payment_date' => $inst['date'],
                'payment_method' => $inst['method'],
                'reference_number' => $inst['reference'] ?? null,
                'remarks' => $inst['remarks'] ?? null,
                'created_by' => auth()->id(),
            ]);
        }

        // Update policy paid_amount and billing status
        $policy->paid_amount = ($policy->paid_amount ?? 0) + $totalPaid;
        if ($policy->paid_amount >= ($policy->amount_due ?? 0)) {
            $policy->billing_status = 'paid';
        } else {
            $policy->billing_status = 'partial';
        }
        $policy->updated_by = auth()->id();
        $policy->save();

        return redirect()->route('policies.installment', $policy->id)
                         ->with('success', 'Installment payment(s) recorded successfully. Total amount paid: ₱' . number_format($totalPaid, 2));
    }

    /**
     * Get client details by ID (for AJAX requests)
     */
    public function getClientDetails($id)
    {
        $client = Client::findOrFail($id);
        return response()->json($client);
    }

    /**
     * Mark policy as availed
     */
    public function markAsAvailed(Policy $policy)
    {
        $policy->expiration_status = 'availed';
        $policy->updated_by = auth()->id();
        $policy->save();

        return redirect()->back()->with('success', 'Policy marked as availed successfully');
    }

    /**
     * Delete the policy file
     */
    public function deleteFile(Policy $policy)
    {
        if ($policy->policy_file) {
            // Delete the file from storage
            Storage::disk('public')->delete($policy->policy_file);
            
            // Update the policy to remove the file reference
            $policy->policy_file = null;
            $policy->updated_by = auth()->id();
            $policy->save();

            return redirect()->back()->with('success', 'Policy file deleted successfully');
        }

        return redirect()->back()->with('error', 'No file to delete');
    }

    /**
     * Delete the walkin file
     */
    public function deleteWalkinFile(Policy $policy)
    {
        if ($policy->walkin_file) {
            // Delete the file from storage
            Storage::disk('public')->delete($policy->walkin_file);
            
            // Update the policy to remove the file reference
            $policy->walkin_file = null;
            $policy->updated_by = auth()->id();
            $policy->save();

            return redirect()->back()->with('success', 'Walk-in file deleted successfully');
        }

        return redirect()->back()->with('error', 'No file to delete');
    }
}