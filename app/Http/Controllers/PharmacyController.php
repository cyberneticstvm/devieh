<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\PaymentMode;
use App\Models\Pharmacy;
use App\Models\PharmacyDetail;
use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $products;

    public function __construct()
    {
        $this->middleware('permission:pharmacy-order-list|pharmacy-order-create|pharmacy-order-edit|pharmacy-order-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:pharmacy-order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pharmacy-order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pharmacy-order-delete', ['only' => ['destroy']]);

        $this->middleware(function ($request, $next) {
            $this->products = Stock::leftJoin('products AS p', 'p.id', 'stocks.product_id')->where('stocks.type', 'pharmacy')->where('stocks.branch_id', Session::get('branch'))->whereNull('order_detail_id')->selectRaw("p.id AS product_id, p.category_id AS cid, CONCAT_WS('-', stocks.unique_pcode, p.name) AS name, stocks.id AS id")->get();
            return $next($request);
        });
    }

    public function index()
    {
        $orders = Pharmacy::withTrashed()->where('branch_id', Session::get('branch'))->whereDate('created_at', Carbon::today())->latest()->get();
        return view('admin.order.pharmacy.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $mrid = decrypt($id);
        if ($mrid > 0) :
            $order = Pharmacy::where('medical_record_id', $mrid)->first();
            $mrecord = MedicalRecord::findOrFail($mrid);
            $pmodes = PaymentMode::all();
            $products = $this->products;
            if ($order) :
                return view('admin.order.pharmacy.edit', compact('mrecord', 'order', 'pmodes', 'products'));
            else :
                return view('admin.order.pharmacy.create', compact('mrecord', 'pmodes', 'products'));
            endif;
        else :
        //
        endif;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $this->validate($request, [
            'total' => 'required|numeric|min:0|not_in:0',
            'payment_mode' => 'required',
        ]);
        try {
            DB::transaction(function () use ($request, $id) {
                $mrecord = MedicalRecord::findOrFail($id);
                $disc = getDiscount($mrecord->mrn_id, $request->discount, $request->total);
                $order = Pharmacy::create([
                    'medical_record_id' => $mrecord->id,
                    'branch_id' => Session::get('branch'),
                    'invoice' => generatePharmacyInvoice(),
                    'total' => $request->total,
                    'discount' => $disc,
                    'total_after_discount' => $request->total - $disc,
                    'payment_mode' => $request->payment_mode,
                    'created_by' => $request->user()->id,
                    'updated_by' => $request->user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                foreach ($request->product_id as $key => $item) :
                    $pdetail = PharmacyDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'batch_number' => $request->batch_number[$key],
                        'dosage' => $request->dosage[$key],
                        'duration' => $request->duration[$key],
                        'price' => $request->price[$key],
                        'total' => $request->tot[$key],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    Stock::where('id', $item)->where('type', 'pharmacy')->update(['order_detail_id' => $pdetail->id]);
                endforeach;
                //PharmacyDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('pharmacy.order')->with("success", "Pharmacy Bill Created Successfully");
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
        $order = Pharmacy::findOrFail(decrypt($id));
        $mrecord = MedicalRecord::findOrFail($order->medical_record_id);
        $pmodes = PaymentMode::all();
        $pdcts = Stock::leftJoin('products AS p', 'p.id', 'stocks.product_id')->where('stocks.type', 'pharmacy')->whereIn('stocks.order_detail_id', $order->details->pluck('id'))->where('stocks.branch_id', Session::get('branch'))->selectRaw("p.id AS product_id, p.category_id AS cid, CONCAT_WS('-', stocks.unique_pcode, p.name) AS name, stocks.id AS id");
        $products = Stock::leftJoin('products AS p', 'p.id', 'stocks.product_id')->where('stocks.type', 'pharmacy')->where('stocks.branch_id', Session::get('branch'))->whereNull('order_detail_id')->selectRaw("p.id AS product_id, p.category_id AS cid, CONCAT_WS('-', stocks.unique_pcode, p.name) AS name, stocks.id AS id")->union($pdcts)->get();
        return view('admin.order.pharmacy.edit', compact('mrecord', 'order', 'pmodes', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'total' => 'required|numeric|min:0|not_in:0',
            'payment_mode' => 'required',
        ]);
        try {
            DB::transaction(function () use ($request, $id) {
                $order = Pharmacy::findOrFail($id);
                $disc = getDiscount($order->mrecord->mrn_id, $request->discount, $request->total);
                $order->update([
                    'total' => $request->total,
                    'discount' => $disc,
                    'total_after_discount' => $request->total - $disc,
                    'payment_mode' => $request->payment_mode,
                    'updated_by' => $request->user()->id,
                    'updated_at' => Carbon::now(),
                ]);
                $data = [];
                Stock::whereIn('id', $order->details->pluck('product_id'))->update([
                    'order_detail_id' => NULL,
                ]);
                PharmacyDetail::where('order_id', $order->id)->delete();
                foreach ($request->product_id as $key => $item) :
                    $pdetail = PharmacyDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'batch_number' => $request->batch_number[$key],
                        'dosage' => $request->dosage[$key],
                        'duration' => $request->duration[$key],
                        'price' => $request->price[$key],
                        'total' => $request->tot[$key],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    Stock::where('id', $item)->where('type', 'pharmacy')->update(['order_detail_id' => $pdetail->id]);
                endforeach;
                //PharmacyDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('pharmacy.order')->with("success", "Pharmacy Bill Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Pharmacy::findOrFail(decrypt($id));
        Stock::whereIn('id', $order->details->pluck('product_id'))->update(['order_detail_id' => NULL]);
        $order->delete();
        return redirect()->route('pharmacy.order')->with("success", "Pharmacy Bill Deleted Successfully");
    }
}
