<?php

namespace App\Http\Controllers\Drishti;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:drishti-order-list|drishti-order-create|drishti-order-edit|drishti-order-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:drishti-order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:drishti-order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:drishti-order-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $orders = Sale::withTrashed()->whereDate('created_at', Carbon::today())->latest()->get();
        return view('admin.drishti.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Item::all();
        return view('admin.drishti.order.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required',
        ]);
        try {
            DB::transaction(function () use ($request) {
                $order = Sale::create([
                    'customer_id' => $request->customer_id,
                    'sale_note' => $request->sale_note,
                    'total' => $request->total,
                    'discount' => $request->discount,
                    'total_after_discount' => $request->total - $request->discount,
                    'balance' => $request->balance,
                    'created_by' => $request->user()->id,
                    'updated_by' => $request->user()->id,
                ]);
                $data = [];
                foreach ($request->product_id as $key => $item) :
                    $product = Item::findOrFail($item);
                    $data[] = [
                        'sale_id' => $order->id,
                        'item' => $product->id,
                        'batch_number' => $request->batch_number[$key],
                        'expiry_date' => $request->expiry_date[$key],
                        'qty' => $request->qty[$key],
                        'qty_free' => ($request->qty_free[$key]) ?? 0,
                        'price' => $request->price[$key],
                        'total' => $request->tot[$key],
                        'tax_percentage' => $product->tax_percentage,
                        'taxable_amount' => ($product->tax_percentage > 0) ? ($request->tot[$key] * $product->tax_percentage) / 100 : 0,
                        'discount' => 0,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                endforeach;
                SaleDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('drishti.order')->with("success", "Order Created Successfully");
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
        $order = Sale::findOrFail(decrypt($id));
        $customers = Customer::all();
        $products = Item::all();
        return view('admin.drishti.order.edit', compact('order', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'customer_id' => 'required',
        ]);
        try {
            DB::transaction(function () use ($request, $id) {
                $order = Sale::findOrFail($id);
                $order->update([
                    'customer_id' => $request->customer_id,
                    'sale_note' => $request->sale_note,
                    'total' => $request->total,
                    'discount' => $request->discount,
                    'total_after_discount' => $request->total - $request->discount,
                    'balance' => $request->balance,
                    'updated_by' => $request->user()->id,
                ]);
                $data = [];
                foreach ($request->product_id as $key => $item) :
                    $product = Item::findOrFail($item);
                    $data[] = [
                        'sale_id' => $order->id,
                        'item' => $product->id,
                        'batch_number' => $request->batch_number[$key],
                        'expiry_date' => $request->expiry_date[$key],
                        'qty' => $request->qty[$key],
                        'qty_free' => ($request->qty_free[$key]) ?? 0,
                        'price' => $request->price[$key],
                        'total' => $request->tot[$key],
                        'tax_percentage' => $product->tax_percentage,
                        'taxable_amount' => ($product->tax_percentage > 0) ? ($request->tot[$key] * $product->tax_percentage) / 100 : 0,
                        'discount' => 0,
                        'created_at' => $order->created_at,
                        'updated_at' => Carbon::now(),
                    ];
                endforeach;
                SaleDetail::where('sale_id', $order->id)->forcedelete();
                SaleDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('drishti.order')->with("success", "Order Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Sale::findOrFail(decrypt($id))->delete();
        SaleDetail::where('sale_id', decrypt($id))->delete();
        return redirect()->route('drishti.order')->with("success", "Order Deleted Successfully");
    }
}
