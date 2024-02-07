<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getAppointmentTime(Request $request)
    {
        $arr = getAppointmentTimeList($request->date, $request->doctor_id, $request->branch_id);
        return response()->json($arr);
    }
}
