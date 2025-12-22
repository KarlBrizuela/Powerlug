<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\SizeCategory;
use App\Exports\ServicesExport;
use Maatwebsite\Excel\Facades\Excel;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('sizeCategory')->orderBy('name')->paginate(15);
        return view('pages.services.index', compact('services'));
    }

    public function create()
    {
        $sizeCategories = SizeCategory::orderBy('name')->get();
        return view('pages.services.create', compact('sizeCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:255',
            'size_category_id' => 'nullable|exists:size_categories,id',
        ]);

        $validated['created_by'] = auth()->id();

        Service::create($validated);

        return redirect()->route('services.index')->with('success', 'Service created successfully');
    }

    public function edit(Service $service)
    {
        $sizeCategories = SizeCategory::orderBy('name')->get();
        return view('pages.services.edit', compact('service', 'sizeCategories'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:255',
            'size_category_id' => 'nullable|exists:size_categories,id',
        ]);

        $service->update($validated);

        return redirect()->route('services.index')->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted');
    }

    /**
     * Get all services
     */
    public function getAll()
    {
        $services = Service::with('sizeCategory')->orderBy('name')->get();
        
        return response()->json($services->map(function($service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'price' => $service->price,
                'size_category' => $service->sizeCategory ? $service->sizeCategory->name : 'N/A',
            ];
        }));
    }

    /**
     * Get services by size category
     */
    public function getBySize(Request $request)
    {
        $size = $request->query('size');
        
        $sizeCategory = SizeCategory::where('name', $size)->first();
        
        if (!$sizeCategory) {
            return response()->json([]);
        }
        
        $services = Service::where('size_category_id', $sizeCategory->id)
                          ->with('sizeCategory')
                          ->orderBy('name')
                          ->get();
        
        return response()->json($services->map(function($service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'price' => $service->price,
                'size_category' => $service->sizeCategory ? $service->sizeCategory->name : 'N/A',
            ];
        }));
    }

    /**
     * Export services to Excel.
     */
    public function export()
    {
        return Excel::download(new ServicesExport, 'services-' . date('Y-m-d-H-i-s') . '.xlsx');
    }
}
