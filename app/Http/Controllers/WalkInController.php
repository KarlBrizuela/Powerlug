<?php

namespace App\Http\Controllers;

use App\Exports\WalkInsExport;
use App\Models\WalkIn;
use App\Models\WalkInInstallment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class WalkInController extends Controller
{
    public function index()
    {
        $walkIns = WalkIn::orderBy('created_at', 'desc')->paginate(100);
        return view('pages.walk-in-index', compact('walkIns'));
    }

    /**
     * Export walk-ins to Excel.
     */
    public function export()
    {
        return Excel::download(new WalkInsExport, 'walk-ins-' . date('Y-m-d-H-i-s') . '.xlsx');
    }

    public function create()
    {
        return view('pages.walk-in-create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|integer|exists:clients,id',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'make_model' => 'nullable|string|max:255',
            'plate_number' => 'nullable|string|max:255',
            'model_year' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'walkin_date' => 'nullable|date',
            'file_upload' => 'nullable|file|max:2048',
            'amount_due' => 'nullable|numeric|min:0',
            'payment_terms' => 'nullable|string|max:255',
        ]);

        // Handle file upload if present
        if ($request->hasFile('file_upload')) {
            $path = $request->file('file_upload')->store('walk-in-files', 'public');
            $validatedData['file_path'] = $path;
        }

        // Get client details to populate walk-in fields
        $client = \App\Models\Client::findOrFail($validatedData['client_id']);
        $validatedData['insured_name'] = $client->firstName . ' ' . $client->lastName;
        $validatedData['unit'] = $validatedData['make_model'] ?? '';
        $validatedData['payment_type'] = 'down_payment'; // Default payment type for walk-ins

        // Generate walk-in number
        $validatedData['walkin_number'] = 'WI-' . date('Ymd') . '-' . str_pad(WalkIn::count() + 1, 4, '0', STR_PAD_LEFT);
        $validatedData['status'] = 'pending';
        $validatedData['paid_amount'] = 0;
        
        // Set total_amount to amount_due if provided
        if (!empty($validatedData['amount_due'])) {
            $validatedData['total_amount'] = $validatedData['amount_due'];
        } else {
            $validatedData['total_amount'] = 0;
        }
        
        // Create the walk-in record
        $walkIn = WalkIn::create($validatedData);
        
        // Create automatic installments if payment_terms is set
        if (!empty($validatedData['payment_terms'])) {
            $this->createAutomaticInstallments($walkIn);
        }

        return redirect()->route('walk-in.index')
            ->with('success', 'Walk-in created successfully.');
    }

    public function show(WalkIn $walkIn)
    {
        return view('pages.walk-in-show', compact('walkIn'));
    }

    public function download(WalkIn $walkIn)
    {
        if (!$walkIn->file_path || !file_exists(storage_path('app/public/' . $walkIn->file_path))) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return response()->download(storage_path('app/public/' . $walkIn->file_path));
    }

    public function deleteFile($id)
    {
        $walkIn = WalkIn::findOrFail($id);
        
        if ($walkIn->file_path && Storage::disk('public')->exists($walkIn->file_path)) {
            Storage::disk('public')->delete($walkIn->file_path);
            $walkIn->update(['file_path' => null]);
        }

        return redirect()->back()->with('success', 'File deleted successfully.');
    }

    /**
     * Create automatic installments based on payment terms (30-day intervals)
     */
    private function createAutomaticInstallments(WalkIn $walkIn)
    {
        $paymentTerms = $walkIn->payment_terms;
        
        // Extract payment term days from string (e.g., "30 days" -> 30)
        preg_match('/(\d+)/', $paymentTerms, $matches);
        $paymentDays = isset($matches[1]) ? intval($matches[1]) : null;
        
        if (!$paymentDays) {
            return; // No valid payment terms
        }
        
        // Calculate number of installments (divide by 30-day intervals)
        $installmentCount = intval($paymentDays / 30);
        
        if ($installmentCount <= 0) {
            return; // No installments needed
        }
        
        // Use today as start date
        $startDate = Carbon::now();
        $amountPerInstallment = $walkIn->amount_due / $installmentCount;
        
        // Create installments at 30-day intervals
        for ($i = 1; $i <= $installmentCount; $i++) {
            $paymentDate = $startDate->copy()->addDays(30 * $i);
            
            WalkInInstallment::create([
                'walkin_id' => $walkIn->id,
                'payment_date' => $paymentDate->toDateString(),
                'amount' => $amountPerInstallment,
                'payment_method' => 'Pending',
                'reference_number' => '',
                'remarks' => 'Auto-generated installment ' . $i . ' of ' . $installmentCount,
                'created_by' => auth()->id(),
            ]);
        }
    }

    public function installment(WalkIn $walkIn)
    {
        $installments = $walkIn->installments()->paginate(10);
        return view('pages.walk-in-installments', compact('walkIn', 'installments'));
    }

    public function storeInstallment(Request $request, WalkIn $walkIn)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $validatedData['walkin_id'] = $walkIn->id;
        $validatedData['created_by'] = auth()->id();

        WalkInInstallment::create($validatedData);

        // Update the paid amount
        $totalPaid = $walkIn->installments()->sum('amount');
        $walkIn->update(['paid_amount' => $totalPaid]);

        // Update status if fully paid
        if ($totalPaid >= $walkIn->total_amount) {
            $walkIn->update(['status' => 'completed']);
        }

        return redirect()->route('walk-in.installment', $walkIn->id)
            ->with('success', 'Installment payment recorded successfully.');
    }

    public function destroy(WalkIn $walkIn)
    {
        if ($walkIn->file_path && Storage::disk('public')->exists($walkIn->file_path)) {
            Storage::disk('public')->delete($walkIn->file_path);
        }

        $walkIn->delete();

        return redirect()->route('walk-in.index')->with('success', 'Walk-in deleted successfully.');
    }
}