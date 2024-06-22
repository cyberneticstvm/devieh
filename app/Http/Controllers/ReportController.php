<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    protected $branches;

    function __construct()
    {
        $this->middleware('permission:report-daybook', ['only' => ['dayBook', 'dayBookFetch']]);
        $this->middleware(function ($request, $next) {
            $this->branches = Branch::when(!in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) {
                return $q->where('id', Session::get('branch'));
            })->get();
            return $next($request);
        });
    }

    function dayBook()
    {
        $inputs = array(date('Y-m-d'), date('Y-m-d'), Session::get('branch'));
        $branches = $this->branches;
        $data = $this->getDayBook(date('Y-m-d'), date('Y-m-d'), Session::get('branch'));
        return view('admin.report.daybook', compact('inputs', 'data', 'branches'));
    }

    function dayBookFetch(Request $request)
    {
        $inputs = array($request->from_date, $request->to_date, $request->branch);
        $branches = $this->branches;
        $data = $this->getDayBook($request->from_date, $request->to_date, $request->branch);
        return view('admin.report.daybook', compact('inputs', 'data', 'branches'));
    }

    function getDayBook($from_date, $to_date, $branch)
    {
        return collect(DB::select("SELECT tbl4.*, s.name AS sname FROM (SELECT tbl3.*, b.name AS bname FROM (SELECT tbl2.*, p.total_after_discount FROM (SELECT tbl1.*, o.discount, o.advance, o.balance, o.order_status, o.total_after_discount AS total, DATE_FORMAT(o.invoice_date, '%d.%b.%Y') AS invoice_date FROM(SELECT mr.id, mr.mrn, mr.name, mr.consultation_fee, DATE_FORMAT(mr.created_at, '%d.%b.%Y') AS created_at, branch_id FROM medical_records mr WHERE IF(?, branch_id = ?, 1) AND mr.deleted_at IS NULL AND DATE(mr.created_at) BETWEEN ? AND ?) AS tbl1 LEFT JOIN orders o ON o.medical_record_id = tbl1.id WHERE o.deleted_at IS NULL) AS tbl2 LEFT JOIN pharmacies p ON p.medical_record_id = tbl2.id WHERE p.deleted_at IS NULL) AS tbl3 LEFT JOIN branches b ON b.id = tbl3.branch_id) AS tbl4 LEFT JOIN statuses s ON s.id=tbl4.order_status", [$branch, $branch, $from_date, $to_date]));
    }
}
