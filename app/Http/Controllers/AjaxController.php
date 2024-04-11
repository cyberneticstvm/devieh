<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getAppointmentTime(Request $request)
    {
        $arr = getAppointmentTimeList($request->date, $request->doctor_id, $request->branch_id);
        return response()->json($arr);
    }

    public function fetchProduct($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function fetchProductForDrishti($id)
    {
        $product = Item::findOrFail($id);
        return response()->json($product);
    }

    public function fetchDrishtiProductsByCategory($category)
    {
        $products = Item::where('category_id', $category)->get();
        return response()->json($products);
    }

    public function fetchProductsByCategory($category)
    {
        $products = Product::where('category_id', $category)->get();
        return response()->json($products);
    }

    public function fetchProductsByCategoryNotIn($category)
    {
        $products = Product::whereNotIn('category_id', [$category])->get();
        return response()->json($products);
    }
}
