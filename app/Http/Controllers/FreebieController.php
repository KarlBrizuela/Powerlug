<?php

namespace App\Http\Controllers;

use App\Models\Freebie;
use App\Exports\FreebiesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FreebieController extends Controller
{
    public function index()
    {
        $freebies = Freebie::latest()->paginate(15);
        return view('pages.freebies.index', compact('freebies'));
    }

    public function create()
    {
        return view('pages.freebies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255',
            'schedule_type' => 'nullable|string',
            'schedule_value' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            // is_active comes from a checkbox which submits 'on' when checked —
            // we'll map it to boolean explicitly below, so don't validate as boolean here.
            'is_active' => 'nullable'
        ]);

    // parse schedule_value into array if provided as comma/newline separated
        $sv = $request->input('schedule_value', '');
        $data['schedule_value'] = $sv !== '' ? array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $sv)))) : null;
    // Normalize is_active to boolean (checkbox sends '1' when checked, '0' via hidden input when unchecked)
    $data['is_active'] = (bool) $request->input('is_active', 0);
    // unit and service will be present in $data from validation if provided

        Freebie::create($data);
        return redirect()->route('freebies.index')->with('success', 'Freebie created');
    }

    public function edit(Freebie $freebie)
    {
        return view('pages.freebies.edit', compact('freebie'));
    }

    public function update(Request $request, Freebie $freebie)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255',
            'schedule_type' => 'nullable|string',
            'schedule_value' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            // see note in store(): map checkbox to boolean after validation
            'is_active' => 'nullable'
        ]);

        $sv = $request->input('schedule_value', '');
        $data['schedule_value'] = $sv !== '' ? array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $sv)))) : null;
    $data['is_active'] = (bool) $request->input('is_active', 0);

        $freebie->update($data);
        return redirect()->route('freebies.index')->with('success', 'Freebie updated');
    }

    public function destroy(Freebie $freebie)
    {
        $freebie->delete();
        return redirect()->route('freebies.index')->with('success', 'Freebie deleted');
    }

    /**
     * Export freebies to Excel.
     */
    public function export()
    {
        return Excel::download(new FreebiesExport, 'freebies-' . date('Y-m-d-H-i-s') . '.xlsx');
    }
}
