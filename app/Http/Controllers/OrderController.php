<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentMode;
use App\Models\Product;
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
    public function __construct()
    {
        $this->middleware('permission:store-order-list|store-order-create|store-order-edit|store-order-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:store-order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:store-order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:store-order-delete', ['only' => ['destroy']]);
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
            $products = Product::all();
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
                $data = [];
                foreach ($request->product_id as $key => $item) :
                    $data[] = [
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
                    ];
                endforeach;
                OrderDetail::insert($data);
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
        $products = Product::all();
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
                OrderDetail::where('order_id', $order->id)->delete();
                $data = [];
                foreach ($request->product_id as $key => $item) :
                    $data[] = [
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
                    ];
                endforeach;
                OrderDetail::insert($data);
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
        Order::findOrFail(decrypt($id))->delete();
        return redirect()->route('store.order')->with("success", "Order Deleted Successfully");
    }
}
