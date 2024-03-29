<?php

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\CampPatient;
use App\Models\Doctor;
use App\Models\Setting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

function currentBranch()
{
    return Branch::find(Session::get('branch'));
}

function settings()
{
    return Setting::all();
}

function thickness()
{
    return array('Not Applicable' => 'Not Applicable', 'Maximum Thin' => 'Maximum Thin', 'Normal Thick' => 'Normal Thick', 'Thin' => 'Thin');
}

function casetypes()
{
    return array('Rexine' => 'Rexine', 'Box' => 'Box');
}

function generatePharmacyInvoice()
{
    $bcode = Branch::findOrFail(Session::get('branch'))->code;
    return DB::table('pharmacies')->selectRaw("CONCAT_WS('/', 'INV', 'PH', '$bcode', LPAD(IFNULL(max(id)+1, 1), 7, '0')) AS ino")->first();
}

function getDocFee($doctor, $opreference)
{
    $days = Setting::where('id', 3)->first()->value;
    $fee = 0;
    $date_diff = DB::table('medical_records')->where('mrn_id', $opreference)->select(DB::raw("IFNULL(DATEDIFF(now(), created_at), 0) as days, CASE WHEN deleted_at IS NULL THEN 1 ELSE 0 END AS status"))->latest()->first();
    $diff = ($date_diff && $date_diff->days > 0) ? $date_diff->days : 0;
    $cstatus = ($date_diff && $date_diff->status > 0) ? $date_diff->status : 0;
    if ($diff == 0 || $diff > $days || ($diff < $days && $cstatus == 1)) :
        $doc = Doctor::findOrFail($doctor);
        $fee = $doc->fee;
    endif;
    return $fee;
}

function getAppointmentTimeList($date, $doctor, $branch)
{
    $arr = [];
    $start_time = Setting::where('id', 4)->first()->value;
    $end_time = Setting::where('id', 5)->first()->value;
    $interval = Setting::where('id', 6)->first()->value;
    $endtime = Carbon::parse($end_time)->toTimeString();
    $starttime = Carbon::parse($start_time)->toTimeString();
    if ($date && $doctor && $branch) :
        $starttime = ($starttime < Carbon::now()->toTimeString() && Carbon::parse($date)->toDate() == Carbon::today()) ? Carbon::now()->endOfHour()->addSecond()->toTimeString() : $starttime;

        $start = strtotime($starttime);

        $appointment = Appointment::select('time as atime')->whereDate('date', $date)->where('doctor_id', $doctor)->where('branch_id', $branch)->pluck('atime')->toArray();
        while ($start <= strtotime($endtime)) :
            $disabled = in_array(Carbon::parse(date('h:i A', $start))->toTimeString(), $appointment) ? 'disabled' : NULL;
            $arr[] = [
                'name' => date('h:i A', $start),
                'id' => Carbon::parse(date('h:i A', $start))->toTimeString(),
                'disabled' => $disabled,
            ];
            $start = strtotime('+' . $interval . ' minutes', $start);
        endwhile;
    endif;
    return $arr;
}

function generateAuthCode()
{
    return date('y') . 'IN' . time();
}

function getDiscount($medical_record_id, $discount, $total)
{
    $discount_percentage_for_camp_patient = 50;
    $camp_patient = CampPatient::where('mrn_id', $medical_record_id)->first();
    if ($camp_patient)
        return ($total * $discount_percentage_for_camp_patient) / 100;
    return $discount;
}
