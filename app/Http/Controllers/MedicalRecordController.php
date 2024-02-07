<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\PaymentMode;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:consultation-list|consultation-create|consultation-edit|consultation-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:consultation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:consultation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:consultation-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $consultations = MedicalRecord::whereDate('created_at', Carbon::today())->where('branch_id', Session::get('branch'))->withTrashed()->latest()->get();
        return view('admin.consultation.index', compact('consultations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($type, $review, $type_id)
    {
        $doctors = Doctor::all();
        $pmodes = PaymentMode::all();
        $patient = [];
        if ($type_id > 0) :
            if ($type == 'Appointment') :
                $patient = Appointment::findOrFail($type_id);
            elseif ($type == 'Camp') :
            //
            else :
                $patient = MedicalRecord::findOrFail($type_id);
            endif;
        endif;
        return view('admin.consultation.create', compact('doctors', 'pmodes', 'type', 'review', 'type_id', 'patient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'age' => 'required|numeric',
            'gender' => 'required',
            'place' => 'required',
            'mobile' => 'required|numeric|digits:10',
            'purpose_of_visit' => 'required',
            'doctor_id' => 'required',
        ]);
        $op_reference = NULL;
        if ($request->review == 'Yes') :
            if ($request->type == 'Appointment') :
                $op_reference = Appointment::findOrFail($request->type_id)->old_mrn;
            else :
                $op_reference = MedicalRecord::where('mrn_id', $request->type_id)->latest()->first()->mrn_id;
            endif;
        endif;
        $mrn_start = Setting::where('id', 7)->first()->value;
        $mrnid = DB::table('medical_records')->selectRaw("IFNULL(MAX(mrn_id)+1, $mrn_start) AS mrnid")->first();
        $bcode = Branch::findOrFail(Session::get('branch'))->code;
        $mrn = DB::table('medical_records')->selectRaw("CONCAT_WS('/', 'MRN', IFNULL(MAX(mrn_id)+1, $mrn_start), '$bcode') AS mrn")->first();
        MedicalRecord::create([
            'mrn' => $mrn->mrn,
            'mrn_id' => $mrnid->mrnid,
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'place' => $request->place,
            'mobile' => $request->mobile,
            'purpose_of_visit' => $request->purpose_of_visit,
            'doctor_id' => $request->doctor_id,
            'branch_id' => Session::get('branch'),
            'consultation_fee' => getDocFee($request->doctor_id, $op_reference),
            'consultation_fee_payment_mode' => $request->consultation_fee_payment_mode,
            'review' => $request->review,
            'cataract_surgery_advised' => $request->cataract_surgery_advised,
            'cataract_surgery_urgent' => $request->cataract_surgery_urgent,
            'post_review_date' => $request->post_review_date,
            'op_reference' => $op_reference,
            'status' => 1,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);
        if ($request->type_id > 0) :
            if ($request->type == 'Appointment') :
                Appointment::findOrFail($request->type_id)->update(['mrn_id' => $mrnid->mrnid]);
            endif;
        /*if ($request->type == 'Camp') :
                CampPatient::findOrFail($request->type_id)->update(['patient_id' => $patient->id]);
            endif;*/
        endif;
        return redirect()->route('consultation')->with('success', 'Consultation has been created successfully!');
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
        $consultation = MedicalRecord::findOrFail(decrypt($id));
        $doctors = Doctor::all();
        $pmodes = PaymentMode::all();
        return view('admin.consultation.edit', compact('consultation', 'doctors', 'pmodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'age' => 'required|numeric',
            'gender' => 'required',
            'place' => 'required',
            'mobile' => 'required|numeric|digits:10',
            'purpose_of_visit' => 'required',
            'doctor_id' => 'required',
        ]);
        $mrecord = MedicalRecord::findOrFail($id);
        MedicalRecord::findOrFail($id)->update([
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'place' => $request->place,
            'mobile' => $request->mobile,
            'purpose_of_visit' => $request->purpose_of_visit,
            'doctor_id' => $request->doctor_id,
            'consultation_fee' => getDocFee($request->doctor_id, $mrecord->mrn_id),
            'consultation_fee_payment_mode' => $request->consultation_fee_payment_mode,
            'cataract_surgery_advised' => $request->cataract_surgery_advised,
            'cataract_surgery_urgent' => $request->cataract_surgery_urgent,
            'post_review_date' => $request->post_review_date,
            'updated_by' => $request->user()->id,
        ]);
        return redirect()->route('consultation')->with('success', 'Consultation has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        MedicalRecord::findOrFail(decrypt($id))->delete();
        return redirect()->back()->with('success', 'Consultation deleted successfully!');
    }
}
