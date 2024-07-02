<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:settings-editor', ['only' => ['editor', 'editorSave']]);
        $this->middleware('permission:settings-extras', ['only' => ['extras', 'extrasSave']]);
    }

    function editor()
    {
        $settings = Setting::whereIn('id', [8, 9])->get()->toArray();
        return view('admin.settings.editor', compact('settings'));
    }

    function editorSave(Request $request)
    {
        $this->validate($request, [
            'footer_text' => 'required',
            'declaration_text' => 'required',
        ]);
        Setting::findOrFail(8)->update(['value' => $request->footer_text]);
        Setting::findOrFail(9)->update(['value' => $request->declaration_text]);
        return redirect()->back()->with("success", "Settings updated successfully");
    }

    function extras()
    {
        $settings = Setting::whereIn('id', [3, 4, 5, 6, 10, 11, 12, 13, 14])->get()->toArray();
        return view('admin.settings.extras', compact('settings'));
    }

    function extrasSave(Request $request)
    {
        $this->validate($request, [
            'appointment_start_time' => 'required',
            'appointment_end_time' => 'required',
            'appointment_interval' => 'required',
            'consultation_free_days' => 'required',
        ]);
        DB::transaction(function () use ($request) {
            Setting::findOrFail(3)->update(['value' => $request->consultation_free_days]);
            Setting::findOrFail(4)->update(['value' => $request->appointment_start_time]);
            Setting::findOrFail(5)->update(['value' => $request->appointment_end_time]);
            Setting::findOrFail(6)->update(['value' => $request->appointment_interval]);
            Setting::findOrFail(10)->update(['value' => $request->restrict_date_for_delivery]);
            Setting::findOrFail(11)->update(['value' => $request->daily_expense_limit]);
            Setting::findOrFail(12)->update(['value' => $request->advisor_commission_level]);
            Setting::findOrFail(13)->update(['value' => $request->invloice_due_amount_limit]);
            Setting::findOrFail(14)->update(['value' => $request->products_delivery_per_day]);
        });
        return redirect()->back()->with("success", "Settings updated successfully");
    }
}
