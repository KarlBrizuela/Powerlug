<?php

namespace App\Http\Controllers;

use App\Models\WalkIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WalkInController extends Controller
{
    public function index()
    {
        $walkIns = WalkIn::orderBy('created_at', 'desc')->paginate(15);
        return view('pages.walk-in-index', compact('walkIns'));
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
            'parts_amount' => 'required|numeric|min:0',
            'labor_cost' => 'required|numeric|min:0',
            'materials_cost' => 'required|numeric|min:0',
            'vat_amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:down_payment,full_payment',
        ]);

        // Handle file upload if present
        if ($request->hasFile('file_upload')) {
            $path = $request->file('file_upload')->store('walk-in-files', 'public');
            $validatedData['file_path'] = $path;
        }

        // Generate walk-in number (you might want to customize this)
        $validatedData['walkin_number'] = 'WI-' . date('Ymd') . '-' . str_pad(WalkIn::count() + 1, 4, '0', STR_PAD_LEFT);
        
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

    public function destroy(WalkIn $walkIn)
    {
        if ($walkIn->file_path && Storage::disk('public')->exists($walkIn->file_path)) {
            Storage::disk('public')->delete($walkIn->file_path);
        }

        $walkIn->delete();

        return redirect()->route('walk-in.index')->with('success', 'Walk-in deleted successfully.');
    }
}