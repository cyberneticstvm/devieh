<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:settings-editor', ['only' => ['editor', 'editorSave']]);
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
}
