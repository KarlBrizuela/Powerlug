<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Claim;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Claim::with(['insuranceProvider', 'policy'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->has('admin_status') && $request->admin_status) {
            $query->where('admin_status', $request->admin_status);
        }

        if ($request->has('superadmin_status') && $request->superadmin_status) {
            $query->where('superadmin_status', $request->superadmin_status);
        }

        $claims = $query->paginate(15)->withQueryString();

        return view('pages.claims.index', compact('claims'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // This app uses the closure route to render the claim form; keep create available if needed.
        return redirect()->route('claims.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_of_claim' => 'nullable|date',
            'client' => 'nullable|string',
            'insurance_provider_id' => 'required|exists:insurance_providers,id',
            'policy_id' => 'required|exists:policies,id',
            'policy_number' => 'required|string',
            'loa_amount' => 'nullable|numeric|min:0',
            'participation_amount' => 'nullable|numeric|min:0',
            'deductible' => 'nullable|numeric|min:0',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'parts' => 'nullable|numeric|min:0',
            'laborCost' => 'nullable|numeric|min:0',
            'materials' => 'nullable|numeric|min:0',
        ]);

        // Auto-generate claim number
        $claimNumber = Claim::generateClaimNumber();

        $data = [
            'date_of_claim' => $validated['date_of_claim'] ?? null,
            'client_name' => $validated['client'] ?? null,
            'insurance_provider_id' => $validated['insurance_provider_id'],
            'policy_id' => $validated['policy_id'],
            'policy_number' => $validated['policy_number'],
            'claim_number' => $claimNumber,
            'loa_amount' => $validated['loa_amount'] ?? null,
            'participation_amount' => $validated['participation_amount'] ?? null,
            'deductible' => $validated['deductible'] ?? null,
            'parts' => $validated['parts'] ?? null,
            'labor_cost' => $validated['laborCost'] ?? null,
            'materials' => $validated['materials'] ?? null,
        ];

        // calculate VAT and total
        $parts = $data['parts'] ?? 0;
        $labor = $data['labor_cost'] ?? 0;
        $materials = $data['materials'] ?? 0;
        $subtotal = $parts + $labor + $materials;
        $vat = round($subtotal * 0.12, 2);
        $total = round($subtotal + $vat, 2);

        $data['vat'] = $vat;
        $data['total_amount'] = $total;

        // handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::random(8) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('claims', $filename, 'public');
            $data['file_path'] = $path;
        }

        $data['created_by'] = auth()->id();

        Claim::create($data);

        return redirect()->route('claims.index')->with('success', 'Claim submitted successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Claim $claim)
    {
        return view('pages.claims.show', compact('claim'));
    }

    /**
     * Download the uploaded file for a claim.
     */
    public function download(Claim $claim)
    {
        if (! $claim->file_path || ! Storage::disk('public')->exists($claim->file_path)) {
            abort(404);
        }

        $fullPath = storage_path('app/public/' . $claim->file_path);
        return response()->download($fullPath);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // optional: implement later
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // optional: implement later
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Claim $claim)
    {
        // delete uploaded file if exists
        if ($claim->file_path && Storage::disk('public')->exists($claim->file_path)) {
            Storage::disk('public')->delete($claim->file_path);
        }

        $claim->delete();

        return redirect()->route('claims.index')->with('success', 'Claim deleted');
    }

    /**
     * Update admin status for a claim.
     */
    public function updateAdminStatus(Request $request, Claim $claim)
    {
        $validated = $request->validate([
            'admin_status' => 'required|in:billed,pending',
        ]);

        $claim->update(['admin_status' => $validated['admin_status']]);

        return redirect()->back()->with('success', 'Admin status updated successfully');
    }

    /**
     * Update superadmin status for a claim.
     */
    public function updateSuperadminStatus(Request $request, Claim $claim)
    {
        $validated = $request->validate([
            'superadmin_status' => 'required|in:cleared,deposited',
        ]);

        $claim->update(['superadmin_status' => $validated['superadmin_status']]);

        return redirect()->back()->with('success', 'Super admin status updated successfully');
    }
}
