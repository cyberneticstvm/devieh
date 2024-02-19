<?php

namespace App\Http\Controllers;

use App\Models\Camp;
use App\Models\CampPatient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CampPatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:camp-patient-list|camp-patient-create|camp-patient-edit|camp-patient-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:camp-patient-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:camp-patient-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:camp-patient-delete', ['only' => ['destroy']]);
    }

    public function index(string $id)
    {
        $patients = CampPatient::whereNull('mrn_id')->latest()->get();
        $camp = Camp::findOrFail(decrypt($id));
        return view('admin.camp.patient.index', compact('patients', 'camp'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $camp = Camp::findOrFail(decrypt($id));
        if ($camp->to_date < Carbon::today())
            return redirect()->back()->with("error", "You cannot add patient to expired camp!");
        return view('admin.camp.patient.create', compact('camp'));
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
            'mobile' => 'required|numeric|digits:10',
            'place' => 'required',
            'registration_date' => 'required|date',
        ]);
        $input = $request->all();
        $input['camp_id'] = decrypt($request->camp_id);
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        CampPatient::create($input);
        return redirect()->route('camp.patient', $request->camp_id)->with('success', 'Patient has been added successfully to the Camp!');
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
        $patient = CampPatient::findOrFail(decrypt($id));
        return view('admin.camp.patient.edit', compact('patient'));
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
            'mobile' => 'required|numeric|digits:10',
            'place' => 'required',
            'registration_date' => 'required|date',
        ]);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        $input['camp_id'] = decrypt($request->camp_id);
        CampPatient::findOrFail($id)->update($input);
        return redirect()->route('camp.patient', $request->camp_id)->with('success', 'Patient has been update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CampPatient::findOrFail(decrypt($id))->delete();
        return redirect()->back()->with('success', 'Patient has been deleted successfully!');
    }
}
