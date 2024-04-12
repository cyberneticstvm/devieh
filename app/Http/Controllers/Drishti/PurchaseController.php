<?php

namespace App\Http\Controllers\Drishti;

use App\Http\Controllers\Controller;
use App\Models\Dpurchase;
use App\Models\DpurchaseDetail;
use App\Models\Item;
use App\Models\Supplier;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:drishti-purchase-list|drishti-purchase-create|drishti-purchase-edit|drishti-purchase-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:drishti-purchase-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:drishti-purchase-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:drishti-purchase-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $purchases = Dpurchase::withTrashed()->whereDate('created_at', Carbon::today())->latest()->get();
        return view('admin.drishti.purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Item::pluck('name', 'id');
        $suppliers = Supplier::pluck('name', 'id');
        return view('admin.drishti.purchase.create', compact('products', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'supplier_id' => 'required',
            'order_date' => 'required',
            'delivery_date' => 'required',
            'supplier_invoice' => 'required',
        ]);
        try {
            DB::transaction(function () use ($request) {
                $purchase = Dpurchase::create([
                    'supplier_id' => $request->supplier_id,
                    'order_date' => $request->order_date,
                    'delivery_date' => $request->delivery_date,
                    'supplier_invoice' => $request->supplier_invoice,
                    'notes' => $request->notes,
                    'created_by' => $request->user()->id,
                    'updated_by' => $request->user()->id,
                ]);
                $data = [];
                foreach ($request->product_id as $key => $item) :
                    $data[] = [
                        'purchase_id' => $purchase->id,
                        'item_id' => $item,
                        'qty' => $request->qty[$key],
                        'batch_number' => $request->batch_number[$key],
                        'expiry_date' => $request->expiry_date[$key],
                        'purchase_price' => $request->purchase_price[$key],
                        'selling_price' => $request->selling_price[$key],
                        'purchase_total' => $request->qty[$key] * $request->purchase_price[$key],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                endforeach;
                DpurchaseDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('drishti.purchase')->with("success", "Purchase Recorded Successfully");
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
        $products = Item::pluck('name', 'id');
        $suppliers = Supplier::pluck('name', 'id');
        $purchase = Dpurchase::findOrFail(decrypt($id));
        return view('admin.drishti.purchase.edit', compact('products', 'suppliers', 'purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'supplier_id' => 'required',
            'order_date' => 'required',
            'delivery_date' => 'required',
            'supplier_invoice' => 'required',
        ]);
        try {
            DB::transaction(function () use ($request, $id) {
                $purchase = Dpurchase::findOrFail($id);
                $purchase->update([
                    'supplier_id' => $request->supplier_id,
                    'order_date' => $request->order_date,
                    'delivery_date' => $request->delivery_date,
                    'supplier_invoice' => $request->supplier_invoice,
                    'notes' => $request->notes,
                    'updated_by' => $request->user()->id,
                ]);
                $data = [];
                foreach ($request->product_id as $key => $item) :
                    $data[] = [
                        'purchase_id' => $purchase->id,
                        'item_id' => $item,
                        'qty' => $request->qty[$key],
                        'batch_number' => $request->batch_number[$key],
                        'expiry_date' => $request->expiry_date[$key],
                        'purchase_price' => $request->purchase_price[$key],
                        'selling_price' => $request->selling_price[$key],
                        'purchase_total' => $request->qty[$key] * $request->purchase_price[$key],
                        'created_at' => $purchase->created_at,
                        'updated_at' => Carbon::now(),
                    ];
                endforeach;
                DpurchaseDetail::where('purchase_id', $purchase->id)->forcedelete();
                DpurchaseDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('drishti.purchase')->with("success", "Purchase Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Dpurchase::findOrFail(decrypt($id))->delete();
        DpurchaseDetail::where('purchase_id', decrypt($id))->delete();
        return redirect()->route('drishti.purchase')->with("success", "Purchase Deleted Successfully");
    }
}
