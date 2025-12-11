<?php

namespace App\Http\Controllers;

use App\Exports\WalkInsExport;
use App\Models\WalkIn;
use App\Models\WalkInInstallment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class WalkInController extends Controller
{
    public function index()
    {
        $walkIns = WalkIn::orderBy('created_at', 'desc')->paginate(15);
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
            'insured_name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'plate_number' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'file_upload' => 'nullable|file|max:2048',
            'payment_type' => 'required|in:down_payment,full_payment',
        ]);

        // Handle file upload if present
        if ($request->hasFile('file_upload')) {
            $path = $request->file('file_upload')->store('walk-in-files', 'public');
            $validatedData['file_path'] = $path;
        }

        // Generate walk-in number (you might want to customize this)
        $validatedData['walkin_number'] = 'WI-' . date('Ymd') . '-' . str_pad(WalkIn::count() + 1, 4, '0', STR_PAD_LEFT);
        $validatedData['status'] = 'pending';
        $validatedData['paid_amount'] = 0;
        
        // Create the walk-in record
        WalkIn::create($validatedData);

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