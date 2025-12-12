<?php

namespace App\Http\Controllers;

use App\Exports\PoliciesExport;
use App\Models\Policy;
use App\Models\Client;
use App\Models\InsuranceProvider;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

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

        // Get all policies (recent first)
        $allPolicies = Policy::latest()->get();

        $policy = null;
        return view('pages.policy', compact('policy', 'clients', 'insuranceProviders', 'freebies', 'services', 'allPolicies'));
    }

    /**
     * Show the form for creating a new walk-in.
     *
     * @return \Illuminate\Http\Response
     */
    public function createWalkin()
    {
        // Load clients for the searchable dropdown
        $clients = Client::orderBy('firstName')->orderBy('lastName')->get();
        
        // Load services to populate the Walk-in "Services Availed" dropdown/checkboxes
        $services = Service::orderBy('name')->get();

        // Load active freebies for the freebie select
        $freebies = \App\Models\Freebie::where('is_active', true)->orderBy('name')->get();

        // Get all walk-ins (recent first)
        $allWalkIns = \App\Models\WalkIn::latest()->get();

        return view('pages.walk-in-form', compact('clients', 'services', 'freebies', 'allWalkIns'));
    }

    /**
     * Show the walk-ins list page.
     *
     * @return \Illuminate\Http\Response
     */
    public function walkinsList()
    {
        // Get all walk-ins (recent first)
        $allWalkIns = \App\Models\WalkIn::latest()->get();

        return view('pages.walk-ins-list', compact('allWalkIns'));
    }

    /**
     * Store a newly created policy in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    // Check if user is submitting policy details
    $hasPolicyData = $request->filled('insurance_provider_id') || 
                         $request->filled('issue_date') || 
                         $request->filled('coverage_from') || 
                         $request->filled('coverage_to') ||
                         $request->filled('chassis_number');

    // Check if user is submitting walk-in details
    $hasWalkinData = $request->filled('walkin_date') || 
                     $request->filled('size') || 
                     $request->has('services') ||
                     $request->hasFile('walkin_file');

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
            
            // Walk-in Details
            'walkin_date' => 'nullable|date',
            'walkin_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'size' => 'nullable|string',
            'services' => 'nullable|array',
            'services.*' => 'nullable|string',
            'service_payment_dues' => 'nullable|array',
            'service_payment_dues.*' => 'nullable|numeric',
            
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
            'premium_remarks' => 'nullable|string',
            'proof_of_payment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,doc,docx|max:5120',
            
            // Status Information
            'policy_type' => 'nullable|in:individual,family,corporate',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'nullable|in:active,inactive,expired,cancelled',
            'billing_status' => 'nullable|in:paid,unpaid,partial',
            'remarks' => 'nullable|string',
        ]);

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

        // Ensure required DB columns start_date/end_date are set
        // Preference: coverage_from/coverage_to -> today
        $today = now()->toDateString();
        if (empty($validated['start_date'])) {
            $validated['start_date'] = $validated['coverage_from'] ?? $today;
        }
        if (empty($validated['end_date'])) {
            $validated['end_date'] = $validated['coverage_to'] ?? $validated['start_date'] ?? $today;
        }

        // Handle file upload if provided
        if ($request->hasFile('policy_file')) {
            $validated['policy_file'] = $request->file('policy_file')->store('policies', 'public');
        }

        // Handle walk-in file upload if provided
        if ($request->hasFile('walkin_file')) {
            $validated['walkin_file'] = $request->file('walkin_file')->store('policies/walk-ins', 'public');
        }

        // Handle proof of payment file upload if provided
        if ($request->hasFile('proof_of_payment')) {
            $validated['proof_of_payment'] = $request->file('proof_of_payment')->store('policies/proofs', 'public');
        }

        // Handle services and service_payment_dues arrays
        if ($request->has('services') && is_array($request->input('services'))) {
            $validated['services'] = $request->input('services');
        }
        
        if ($request->has('service_payment_dues') && is_array($request->input('service_payment_dues'))) {
            $validated['service_payment_dues'] = $request->input('service_payment_dues');
        }

        $policy = Policy::create($validated);

        // If the policy number wasn't provided by user, set it to the auto-increment id (or any desired format)
        if (empty($providedPolicyNumber)) {
            // Option: use numeric id directly or prefix like POL-<id>
            $policy->policy_number = $policy->id; // or: 'POL-' . $policy->id
            $policy->save();
        }

        return redirect()->route('policies.show', $policy->id)->with('success', 'Policy created successfully');
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
        // Check if user is submitting policy details
        $hasPolicyData = $request->filled('insurance_provider') || 
                         $request->filled('issue_date') || 
                         $request->filled('coverage_from') || 
                         $request->filled('coverage_to') ||
                         $request->filled('chassis_number');

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
            'premium_remarks' => 'nullable|string',
            
            // Status Information
            'policy_type' => 'nullable|in:individual,family,corporate',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'nullable|in:active,inactive,expired,cancelled',
            'billing_status' => 'nullable|in:paid,unpaid,partial',
            'remarks' => 'nullable|string',
        ]);

        // If bank_transfer was set to OTHER, replace with manual value if provided
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
     * Export policies to Excel.
     */
    public function export()
    {
        return Excel::download(new PoliciesExport, 'policies-' . date('Y-m-d-H-i-s') . '.xlsx');
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

    /**
     * Handle payment reminder attachments upload
     */
    public function uploadPaymentReminderAttachments(Request $request)
    {
        try {
            $request->validate([
                'policy_id' => 'required|exists:policies,id',
                'attachments' => 'required|array|min:1',
                'attachments.*' => 'file|image|mimes:jpg,jpeg,png,gif,webp|max:5120', // 5MB per file, images only
            ]);

            $policy = Policy::findOrFail($request->input('policy_id'));
            
            // Initialize payment_reminder_attachments array if it doesn't exist
            $attachments = is_array($policy->payment_reminder_attachments) ? $policy->payment_reminder_attachments : [];

            $uploadedFiles = [];

            // Store all files
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Get file info before moving
                    $originalName = $file->getClientOriginalName();
                    $fileSize = $file->getSize();
                    $mimeType = $file->getMimeType();
                    
                    // Create directory if it doesn't exist
                    $directory = public_path('policies/payment-reminders');
                    if (!file_exists($directory)) {
                        mkdir($directory, 0755, true);
                    }
                    
                    // Generate unique filename
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    // Move file directly to public folder
                    $file->move($directory, $filename);
                    
                    $filePath = 'policies/payment-reminders/' . $filename;
                    
                    // Store metadata in the array
                    $attachments[] = [
                        'file_path' => $filePath,
                        'name' => $originalName,
                        'size' => $fileSize,
                        'mime_type' => $mimeType,
                        'uploaded_at' => now()->toDateTimeString(),
                        'uploaded_by' => auth()->id(),
                    ];

                    $uploadedFiles[] = [
                        'name' => $originalName,
                        'size' => $fileSize,
                        'path' => $filePath,
                    ];
                }

                // Save the attachments array to the policy
                $policy->payment_reminder_attachments = $attachments;
                $policy->updated_by = auth()->id();
                $policy->save();
            }

            return response()->json([
                'success' => true,
                'message' => count($uploadedFiles) . ' file(s) uploaded successfully',
                'files' => $uploadedFiles,
                'total_attachments' => count($attachments),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Payment reminder attachment upload error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error uploading files: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a payment reminder attachment
     */
    public function deletePaymentReminderAttachment($policyId, $fileIndex)
    {
        try {
            Log::info('Delete attachment request', ['policyId' => $policyId, 'fileIndex' => $fileIndex]);
            
            // Get the policy
            $policy = Policy::findOrFail($policyId);
            Log::info('Policy found', ['policyId' => $policy->id]);
            
            // Validate that fileIndex is an integer
            if (!is_numeric($fileIndex) || $fileIndex < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid file index',
                ], 400);
            }

            $fileIndex = (int)$fileIndex;
            $attachments = is_array($policy->payment_reminder_attachments) ? $policy->payment_reminder_attachments : [];
            Log::info('Attachments count', ['count' => count($attachments), 'index' => $fileIndex]);

            if (isset($attachments[$fileIndex])) {
                // Delete the file from public folder
                $filePath = public_path($attachments[$fileIndex]['file_path']);
                Log::info('Deleting file', ['path' => $filePath, 'exists' => file_exists($filePath)]);
                
                if (file_exists($filePath)) {
                    unlink($filePath);
                    Log::info('File deleted successfully');
                }

                // Remove from array
                unset($attachments[$fileIndex]);
                $attachments = array_values($attachments); // Reindex array

                // Save updated attachments
                $policy->payment_reminder_attachments = $attachments;
                $policy->updated_by = auth()->id();
                $policy->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Attachment deleted successfully',
                    'total_attachments' => count($attachments),
                ]);
            }

            Log::warning('Attachment not found at index', ['index' => $fileIndex, 'total' => count($attachments)]);
            return response()->json([
                'success' => false,
                'message' => 'Attachment not found',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Payment reminder attachment delete error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error deleting attachment: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get payment reminder attachments for a policy (API endpoint)
     */
    public function getPaymentReminderAttachments(Policy $policy)
    {
        try {
            // Get attachments from JSON column - ensure it's an array
            $attachments = $policy->payment_reminder_attachments;
            
            // If null or empty, return empty array
            if (!$attachments) {
                $attachments = [];
            }
            
            // If it's a string, decode it
            if (is_string($attachments)) {
                $attachments = json_decode($attachments, true) ?? [];
            }
            
            // Ensure it's always an array
            if (!is_array($attachments)) {
                $attachments = [];
            }
            
            return response()->json([
                'success' => true,
                'attachments' => $attachments
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching attachments: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'attachments' => []
            ], 500);
        }
    }
}