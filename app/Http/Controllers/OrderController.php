<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentMode;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $products;
    public function __construct()
    {
        $this->middleware('permission:store-order-list|store-order-create|store-order-edit|store-order-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:store-order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:store-order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:store-order-delete', ['only' => ['destroy']]);

        $this->middleware(function ($request, $next) {
            $this->products = Stock::leftJoin('products AS p', 'p.id', 'stocks.product_id')->where('stocks.type', 'store')->where('stocks.branch_id', Session::get('branch'))->whereNull('order_detail_id')->selectRaw("p.id AS product_id, p.category_id AS cid, CONCAT_WS('-', stocks.unique_pcode, p.name) AS name, stocks.id AS id")->get();
            return $next($request);
        });
    }

    public function index()
    {
        $orders = Order::withTrashed()->where('branch_id', Session::get('branch'))->whereDate('created_at', Carbon::today())->latest()->get();
        return view('admin.order.store.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $mrid = decrypt($id);
        if ($mrid > 0) :
            $order = Order::where('medical_record_id', $mrid)->first();
            $mrecord = MedicalRecord::findOrFail($mrid);
            $pmodes = PaymentMode::all();
            $products = $this->products;
            $advisors = User::all();
            if ($order) :
                return view('admin.order.store.edit', compact('mrecord', 'order', 'pmodes', 'products', 'advisors'));
            else :
                return view('admin.order.store.create', compact('mrecord', 'pmodes', 'products', 'advisors'));
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
            'advance_payment_mode' => 'required_unless:advance,0',
        ]);
        try {
            DB::transaction(function () use ($request, $id) {
                $mrecord = MedicalRecord::findOrFail($id);
                $mrecord->update([
                    'cataract_surgery_advised' => $request->cataract_surgery_advised,
                    'cataract_surgery_urgent' => $request->cataract_surgery_urgent,
                    'consultation_fee_payment_mode' => $request->consultation_fee_payment_mode,
                    'post_review_date' => $request->post_review_date,
                    'status' => 2,
                ]);
                $order = Order::create([
                    'medical_record_id' => $mrecord->id,
                    'branch_id' => Session::get('branch'),
                    'auth_code' => generateAuthCode(),
                    'fwc' => ($request->fwc) ?? 0,
                    'hdl' => ($request->hdl) ?? 0,
                    'noa' => ($request->noa) ?? 0,
                    'urg' => ($request->urg) ?? 0,
                    'tpc' => ($request->tpc) ?? 0,
                    'case_type' => $request->case_type,
                    'product_advisor' => $request->product_advisor,
                    'remarks' => $request->remarks,
                    'total' => $request->total,
                    'discount' => $request->discount,
                    'total_after_discount' => $request->total - $request->discount,
                    'advance' => $request->advance,
                    'balance' => $request->balance,
                    'advance_payment_mode' => $request->advance_payment_mode,
                    'balance_payment_mode' => $request->balance_payment_mode,
                    'order_status' => 2,
                    'created_by' => $request->user()->id,
                    'updated_by' => $request->user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                foreach ($request->product_id as $key => $item) :
                    $odetail = OrderDetail::create([
                        'order_id' => $order->id,
                        'eye' => $request->eye[$key],
                        'product_type' => $request->product_type[$key],
                        'sph' => $request->sph[$key],
                        'cyl' => $request->cyl[$key],
                        'axis' => $request->axis[$key],
                        'add' => $request->add[$key],
                        'dia' => $request->dia[$key],
                        'thick' => $request->thick[$key],
                        'ipd' => $request->ipd[$key],
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'price' => $request->price[$key],
                        'total' => $request->tot[$key],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    Stock::where('id', $item)->where('type', 'store')->update(['order_detail_id' => $odetail->id]);
                endforeach;
                //OrderDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('store.order')->with("success", "Order Created Successfully");
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
        $order = Order::findOrFail(decrypt($id));
        $mrecord = MedicalRecord::findOrFail($order->medical_record_id);
        $pmodes = PaymentMode::all();
        $pdcts = Stock::leftJoin('products AS p', 'p.id', 'stocks.product_id')->where('stocks.type', 'store')->whereIn('stocks.order_detail_id', $order->details->pluck('id'))->where('stocks.branch_id', Session::get('branch'))->selectRaw("p.id AS product_id, p.category_id AS cid, CONCAT_WS('-', stocks.unique_pcode, p.name) AS name, stocks.id AS id");
        $products = Stock::leftJoin('products AS p', 'p.id', 'stocks.product_id')->where('stocks.type', 'store')->where('stocks.branch_id', Session::get('branch'))->whereNull('order_detail_id')->selectRaw("p.id AS product_id, p.category_id AS cid, CONCAT_WS('-', stocks.unique_pcode, p.name) AS name, stocks.id AS id")->union($pdcts)->get();
        $advisors = User::all();
        return view('admin.order.store.edit', compact('mrecord', 'order', 'pmodes', 'products', 'advisors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'total' => 'required|numeric|min:0|not_in:0',
            'advance_payment_mode' => 'required_unless:advance,0',
        ]);
        try {
            DB::transaction(function () use ($request, $id) {
                $order = Order::findOrFail($id);
                $mrecord = MedicalRecord::findOrFail($order->medical_record_id);
                $mrecord->update([
                    'cataract_surgery_advised' => $request->cataract_surgery_advised,
                    'cataract_surgery_urgent' => $request->cataract_surgery_urgent,
                    'consultation_fee_payment_mode' => $request->consultation_fee_payment_mode,
                    'post_review_date' => $request->post_review_date,
                ]);
                $order->update([
                    'fwc' => ($request->fwc) ?? 0,
                    'hdl' => ($request->hdl) ?? 0,
                    'noa' => ($request->noa) ?? 0,
                    'urg' => ($request->urg) ?? 0,
                    'tpc' => ($request->tpc) ?? 0,
                    'case_type' => $request->case_type,
                    'product_advisor' => $request->product_advisor,
                    'remarks' => $request->remarks,
                    'total' => $request->total,
                    'discount' => $request->discount,
                    'total_after_discount' => $request->total - $request->discount,
                    'advance' => $request->advance,
                    'balance' => $request->balance,
                    'advance_payment_mode' => $request->advance_payment_mode,
                    'balance_payment_mode' => $request->balance_payment_mode,
                    'updated_by' => $request->user()->id,
                    'updated_at' => Carbon::now(),
                ]);
                Stock::whereIn('id', $order->details->pluck('product_id'))->update([
                    'order_detail_id' => NULL,
                ]);
                OrderDetail::where('order_id', $order->id)->delete();
                foreach ($request->product_id as $key => $item) :
                    $odetail = OrderDetail::create([
                        'order_id' => $order->id,
                        'eye' => $request->eye[$key],
                        'product_type' => $request->product_type[$key],
                        'sph' => $request->sph[$key],
                        'cyl' => $request->cyl[$key],
                        'axis' => $request->axis[$key],
                        'add' => $request->add[$key],
                        'dia' => $request->dia[$key],
                        'thick' => $request->thick[$key],
                        'ipd' => $request->ipd[$key],
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'price' => $request->price[$key],
                        'total' => $request->tot[$key],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    Stock::where('id', $item)->where('type', 'store')->update(['order_detail_id' => $odetail->id]);
                endforeach;
                //OrderDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('store.order')->with("success", "Order Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail(decrypt($id));
        Stock::whereIn('id', $order->details->pluck('product_id'))->update(['order_detail_id' => NULL]);
        $order->delete();
        return redirect()->route('store.order')->with("success", "Order Deleted Successfully");
    }
}
