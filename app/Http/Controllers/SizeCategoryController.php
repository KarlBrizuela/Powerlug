<?php

namespace App\Http\Controllers;

use App\Models\SizeCategory;
use Illuminate\Http\Request;

class SizeCategoryController extends Controller
{
    /**
     * Display a listing of size categories.
     */
    public function index()
    {
        $sizeCategories = SizeCategory::orderBy('name')->paginate(15);
        return view('pages.size-categories.index', compact('sizeCategories'));
    }

    /**
     * Show the form for creating a new size category.
     */
    public function create()
    {
        return view('pages.size-categories.create');
    }

    /**
     * Store a newly created size category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:size_categories',
            'description' => 'nullable|string',
        ]);

        SizeCategory::create($validated);

        return redirect()->route('size-categories.index')->with('success', 'Size Category created successfully');
    }

    /**
     * Show the form for editing the specified size category.
     */
    public function edit(SizeCategory $sizeCategory)
    {
        return view('pages.size-categories.edit', compact('sizeCategory'));
    }

    /**
     * Update the specified size category in storage.
     */
    public function update(Request $request, SizeCategory $sizeCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:size_categories,name,' . $sizeCategory->id,
            'description' => 'nullable|string',
        ]);

        $sizeCategory->update($validated);

        return redirect()->route('size-categories.index')->with('success', 'Size Category updated successfully');
    }

    /**
     * Remove the specified size category from storage.
     */
    public function destroy(SizeCategory $sizeCategory)
    {
        $sizeCategory->delete();
        return redirect()->route('size-categories.index')->with('success', 'Size Category deleted successfully');
    }
}
