<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\PaymentMode;
use App\Models\Pharmacy;
use App\Models\PharmacyDetail;
use App\Models\Product;
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
    public function __construct()
    {
        $this->middleware('permission:pharmacy-order-list|pharmacy-order-create|pharmacy-order-edit|pharmacy-order-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:pharmacy-order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pharmacy-order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pharmacy-order-delete', ['only' => ['destroy']]);
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
            $products = Product::where('category_id', 3)->get();
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
                    'invoice' => generatePharmacyInvoice()->ino,
                    'total' => $request->total,
                    'discount' => $disc,
                    'total_after_discount' => $request->total - $disc,
                    'payment_mode' => $request->payment_mode,
                    'created_by' => $request->user()->id,
                    'updated_by' => $request->user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $data = [];
                foreach ($request->product_id as $key => $item) :
                    $data[] = [
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
                    ];
                endforeach;
                PharmacyDetail::insert($data);
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
        $products = Product::all();
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
                PharmacyDetail::where('order_id', $order->id)->delete();
                foreach ($request->product_id as $key => $item) :
                    $data[] = [
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
                    ];
                endforeach;
                PharmacyDetail::insert($data);
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
        Pharmacy::findOrFail(decrypt($id))->delete();
        return redirect()->route('pharmacy.order')->with("success", "Pharmacy Bill Deleted Successfully");
    }
}
