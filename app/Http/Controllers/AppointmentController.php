<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:appointment-list|appointment-create|appointment-edit|appointment-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:appointment-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:appointment-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:appointment-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $appointments = Appointment::where('branch_id', Session::get('branch'))->whereNull('mrn_id')->withTrashed()->latest()->get();
        return view('admin.appointment.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = Doctor::all();
        $branches = Branch::all();
        return view('admin.appointment.create', compact('doctors', 'branches'));
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
            'branch_id' => 'required',
            'doctor_id' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        Appointment::create($input);
        return redirect()->route('appointment')->with('success', 'Appointment has been created successfully!');
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
        $appointment = Appointment::findOrFail(decrypt($id));
        $doctors = Doctor::all();
        $branches = Branch::all();
        $times = collect(getAppointmentTimeList($appointment->date, $appointment->doctor_id, $appointment->branch_id));
        return view('admin.appointment.edit', compact('doctors', 'branches', 'appointment', 'times'));
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
            'branch_id' => 'required',
            'doctor_id' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);
        $appointment = Appointment::findOrFail($id);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        $appointment->update($input);
        return redirect()->route('appointment')->with('success', 'Appointment has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail(decrypt($id))->delete();
        return redirect()->route('appointment')->with('success', 'Appointment has been deleted successfully!');
    }
}
