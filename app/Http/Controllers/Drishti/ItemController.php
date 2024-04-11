<?php

namespace App\Http\Controllers\Drishti;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:drishti-product-list|drishti-product-create|drishti-product-edit|drishti-product-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:drishti-product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:drishti-product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:drishti-product-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $products = Item::withTrashed()->latest()->get();
        return view('admin.drishti.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('id', 3)->orderBy('name')->get();
        $subcategories = Subcategory::where('category_id', 3)->orderBy('name')->get();
        return view('admin.drishti.product.create', compact('categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'subcategory_id' => 'required',
        ]);
        $input = $request->all();
        $category = Category::findOrFail($request->category_id)->name;
        $input['code'] = substr(strtoupper($category), 0, 1) . random_int(100000, 999999);
        Item::create($input);
        return redirect()->route('drishti.item')
            ->with('success', 'Product has been created successfully');
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
        $categories = Category::where('id', 3)->orderBy('name')->get();
        $subcategories = Subcategory::where('category_id', 3)->orderBy('name')->get();
        $product = Item::findOrFail(decrypt($id));
        return view('admin.drishti.product.edit', compact('categories', 'subcategories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'subcategory_id' => 'required',
        ]);
        $input = $request->all();
        Item::findOrFail($id)->update($input);
        return redirect()->route('drishti.item')
            ->with('success', 'Product has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Item::findOrFail(decrypt($id))->delete();
        return redirect()->route('drishti.item')
            ->with('success', 'Product has been deleted successfully');
    }
}
