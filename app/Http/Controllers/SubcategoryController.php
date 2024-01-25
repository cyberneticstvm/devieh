<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Exception;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:subcategory-list|subcategory-create|subcategory-edit|subcategory-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:subcategory-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:subcategory-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subcategory-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $subcategories = Subcategory::withTrashed()->latest()->get();
        return view('admin.subcategory.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::withTrashed()->latest()->get();
        return view('admin.subcategory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
        ]);
        $input = $request->all();
        try {
            Subcategory::create($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('subcategory')
            ->with('success', 'Subcategory has been created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::withTrashed()->latest()->get();
        $subcategory = Subcategory::findOrFail(decrypt($id));
        return view('admin.subcategory.edit', compact('categories', 'subcategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
        ]);
        $input = $request->all();
        Subcategory::findOrFail($id)->update($input);
        return redirect()->route('subcategory')
            ->with('success', 'Subcategory has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Subcategory::findOrFail(decrypt($id))->delete();
        return redirect()->route('subcategory')
            ->with('success', 'Subcategory has been deleted successfully');
    }
}
