<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HelperController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:search', ['only' => ['search', 'searchFetch']]);
    }

    public function search()
    {
        $inputs = array('0' => 'name', '1' => '', '2' => 'exact');
        $result = [];
        return view('admin.search.index', compact('inputs', 'result'));
    }

    public function searchFetch(Request $request)
    {
        $this->validate($request, [
            'search_by' => 'required',
            'search_term' => 'required',
            'search_condition' => 'required',
        ]);
        $inputs = array('0' => $request->search_by, '1' => $request->search_term, '2' => $request->search_condition);
        $result = MedicalRecord::where('branch_id', Session::get('branch'))->when($request->search_by == 'mrn', function ($q) use ($request) {
            return $q->where('mrn_id', $request->search_term);
        })->when($request->search_by == 'name', function ($q) use ($request) {
            return $q->where('name', $request->search_term);
        })->when($request->search_by == 'mobile', function ($q) use ($request) {
            return $q->where('mobile', $request->search_term);
        })->get();
        return view('admin.search.index', compact('inputs', 'result'));
    }

    public function generateInvoice($oid)
    {
        Order::findOrFail(decrypt($oid))->update([
            'invoice' => generateOrderInvoice(),
            'invoice_date' => Carbon::now(),
            'order_status' => 5,
        ]);
        return redirect()->back()->with("success", "Invoice generated successfully");
    }
}
