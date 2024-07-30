<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
        $this->middleware('permission:product-unique-list', ['only' => ['uniqueList']]);
    }

    public function index()
    {
        $products = Product::withTrashed()->latest()->get();
        return view('admin.product.index', compact('products'));
    }

    public function uniqueList()
    {
        $products = Stock::withTrashed()->latest()->get();
        return view('admin.product.list', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $subcategories = Subcategory::orderBy('name')->get();
        return view('admin.product.create', compact('categories', 'subcategories'));
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
            'eligible_for_commission' => 'required',
        ]);
        $input = $request->all();
        $category = Category::findOrFail($request->category_id)->name;
        $input['code'] = substr(strtoupper($category), 0, 1) . random_int(100000, 999999);
        Product::create($input);
        return redirect()->route('product')
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
        $categories = Category::orderBy('name')->get();
        $subcategories = Subcategory::orderBy('name')->get();
        $product = Product::findOrFail(decrypt($id));
        return view('admin.product.edit', compact('categories', 'subcategories', 'product'));
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
            'eligible_for_commission' => 'required',
        ]);
        $input = $request->all();
        Product::findOrFail($id)->update($input);
        return redirect()->route('product')
            ->with('success', 'Product has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::findOrFail(decrypt($id))->delete();
        return redirect()->route('product')
            ->with('success', 'Product has been deleted successfully');
    }
}
