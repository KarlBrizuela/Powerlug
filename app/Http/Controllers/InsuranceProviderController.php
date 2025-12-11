<?php

namespace App\Http\Controllers;

use App\Models\InsuranceProvider;
use App\Exports\InsuranceProvidersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InsuranceProviderController extends Controller
{
    public function index()
    {
        $providers = InsuranceProvider::latest()->paginate(10);
        return view('pages.insurance-provider-list', compact('providers'));
    }

    public function create()
    {
        return view('pages.new-insuranceprovider');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|unique:insurance_providers',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'banks' => 'nullable|string'
        ]);

    // Set default value for is_active if not provided
    $validatedData['is_active'] = $request->has('is_active');

    // Parse banks (newline or comma separated) into array
    $banksInput = $request->input('banks', '');
    $banks = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $banksInput))));
    $validatedData['banks'] = $banks;

    InsuranceProvider::create($validatedData);

        return redirect()->route('insurance-providers.index')
                        ->with('success', 'Insurance Provider created successfully');
    }

    public function edit(InsuranceProvider $insuranceProvider)
    {
        return view('pages.edit-insuranceprovider', compact('insuranceProvider'));
    }

    public function update(Request $request, InsuranceProvider $insuranceProvider)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|unique:insurance_providers,code,' . $insuranceProvider->id,
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'banks' => 'nullable|string'
        ]);

    // Set default value for is_active if not provided
    $validatedData['is_active'] = $request->has('is_active');

    // Parse banks into array
    $banksInput = $request->input('banks', '');
    $banks = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $banksInput))));
    $validatedData['banks'] = $banks;

    $insuranceProvider->update($validatedData);

        return redirect()->route('insurance-providers.index')
                        ->with('success', 'Insurance Provider updated successfully');
    }

    public function destroy(InsuranceProvider $insuranceProvider)
    {
        $insuranceProvider->delete();
        return redirect()->route('insurance-providers.index')
                        ->with('success', 'Insurance Provider deleted successfully');
    }

    /**
     * Export insurance providers to Excel.
     */
    public function export()
    {
        return Excel::download(new InsuranceProvidersExport, 'insurance-providers-' . date('Y-m-d-H-i-s') . '.xlsx');
    }
}