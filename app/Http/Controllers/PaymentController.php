<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:payment-list|payment-create|payment-edit|payment-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:payment-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payment-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payment-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $payments = Payment::withTrashed()->latest()->get();
        return view('admin.payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        try {
            $mrecord = MedicalRecord::findOrFail(decrypt($id));
            $pmodes = PaymentMode::all();
            $order = Order::where('medical_record_id', $mrecord->id)->firstOrFail();
            $paid = Payment::where('medical_record_id', $mrecord->id)->sum('amount');
            $balance = $order->balance - $paid;
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
        return view('admin.payment.create', compact('mrecord', 'balance', 'pmodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'payment_mode' => 'required',
            'payment_type' => 'required',
        ]);
        try {
            $input = $request->except(array('balance'));
            if ($request->payment_type == 'Balance' && ceil($request->balance) != ceil($request->amount))
                throw new Exception("Balance amount should be" . $request->balance);
            $input['medical_record_id'] = decrypt($request->medical_record_id);
            $input['branch_id'] = Session::get('branch');
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            Payment::create($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('payments')
            ->with('success', 'Payment recorded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $this->validate($request, [
            'mrn' => 'required',
        ]);
        try {
            $mrecord = MedicalRecord::where('mrn_id', $request->mrn)->firstOrFail();
            $balance = $this->getBalance($mrecord->id, 0);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return view('admin.payment.proceed', compact('mrecord', 'balance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::findOrFail(decrypt($id));
        $pmodes = PaymentMode::all();
        return view('admin.payment.edit', compact('payment', 'pmodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'amount' => 'required',
            'payment_mode' => 'required',
            'payment_type' => 'required',
        ]);
        try {
            $input = $request->except(array('balance'));
            $mrecord = MedicalRecord::findOrFail(decrypt($request->medical_record_id));
            $balance = $this->getBalance($mrecord->id, $request->balance);
            if ($request->payment_type == 'Balance' && ceil($balance) != ceil($request->amount))
                throw new Exception("Balance amount should be " . $balance);
            $input['medical_record_id'] = decrypt($request->medical_record_id);
            $input['updated_by'] = $request->user()->id;
            Payment::findOrFail($id)->update($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('payments')
            ->with('success', 'Payment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Payment::findOrFail(decrypt($id))->delete();
        return redirect()->route('payments')
            ->with('success', 'Payment deleted successfully');
    }

    public function getBalance($medical_record_id, $bal)
    {
        $order = Order::where('medical_record_id', $medical_record_id)->firstOrFail();
        $paid = Payment::where('medical_record_id', $medical_record_id)->sum('amount');
        $balance = ($order->balance + $bal) - $paid;
        return $balance;
    }
}
