<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use App\Models\Transfer;
use App\Models\TransferDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StorePurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:store-purchase-list|store-purchase-create|store-purchase-edit|store-purchase-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:store-purchase-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:store-purchase-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:store-purchase-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $purchases = Purchase::withTrashed()->where('type', 'store')->latest()->get();
        return view('admin.purchase.store.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::whereNotIn('category_id', [3])->pluck('name', 'id');
        $suppliers = Supplier::pluck('name', 'id');
        return view('admin.purchase.store.create', compact('products', 'suppliers'));
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
                $purchase = Purchase::create([
                    'supplier_id' => $request->supplier_id,
                    'order_date' => $request->order_date,
                    'delivery_date' => $request->delivery_date,
                    'supplier_invoice' => $request->supplier_invoice,
                    'type' => 'store',
                    'notes' => $request->notes,
                    'created_by' => $request->user()->id,
                    'updated_by' => $request->user()->id,
                ]);
                $transfer = Transfer::create([
                    'from_branch' => 0,
                    'to_branch' => 0,
                    'transfer_note' => 'Purchase recorded with id of ' . $purchase->id,
                    'type' => 'store',
                    'created_by' => $request->user()->id,
                    'updated_by' => $request->user()->id,
                ]);
                $data = [];
                $data1 = [];
                foreach ($request->product_id as $key => $item) :
                    $data[] = [
                        'purchase_id' => $purchase->id,
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'purchase_price' => $request->purchase_price[$key],
                        'selling_price' => $request->selling_price[$key],
                        'purchase_total' => $request->qty[$key] * $request->purchase_price[$key],
                        'type' => 'store',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                    $data1[] = [
                        'transfer_id' => $transfer->id,
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'from_branch' => 0,
                        'to_branch' => 0,
                        'type' => 'store',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                endforeach;
                PurchaseDetail::insert($data);
                TransferDetail::insert($data1);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('store.purchase')->with("success", "Purchase Recorded Successfully");
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
        $products = Product::whereNotIn('category_id', [3])->pluck('name', 'id');
        $suppliers = Supplier::pluck('name', 'id');
        $purchase = Purchase::findOrFail(decrypt($id));
        return view('admin.purchase.store.edit', compact('products', 'suppliers', 'purchase'));
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
                $tr = Transfer::where('transfer_note', 'LIKE', '%' . $id)->firstOrFail();
                Purchase::findOrFail($id)->update([
                    'supplier_id' => $request->supplier_id,
                    'order_date' => $request->order_date,
                    'delivery_date' => $request->delivery_date,
                    'supplier_invoice' => $request->supplier_invoice,
                    'type' => 'store',
                    'notes' => $request->notes,
                    'updated_by' => $request->user()->id,
                ]);
                $data = [];
                $data1 = [];
                foreach ($request->product_id as $key => $item) :
                    $data[] = [
                        'purchase_id' => $id,
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'purchase_price' => $request->purchase_price[$key],
                        'selling_price' => $request->selling_price[$key],
                        'purchase_total' => $request->qty[$key] * $request->purchase_price[$key],
                        'type' => 'store',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                    $data1[] = [
                        'transfer_id' => $tr->id,
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'from_branch' => 0,
                        'to_branch' => 0,
                        'type' => 'store',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                endforeach;
                PurchaseDetail::findOrFail($id)->delete();
                TransferDetail::findOrFail($tr->id)->delete();
                PurchaseDetail::insert($data);
                TransferDetail::insert($data1);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('store.purchase')->with("success", "Purchase Recorded Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $tr = Transfer::where('transfer_note', 'LIKE', '%' . decrypt($id))->firstOrFail();
                Purchase::findOrFail(decrypt($id))->delete();
                Transfer::findOrFail($tr->id)->delete();
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
        return redirect()->route('store.purchase')->with("success", "Purchase Deleted Successfully");
    }
}
