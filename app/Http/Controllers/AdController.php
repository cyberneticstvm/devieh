<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdSettlement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:ad-list|ad-create|ad-edit|ad-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:ad-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:ad-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:ad-delete', ['only' => ['destroy']]);

        $this->middleware('permission:ad-settlement-create', ['only' => ['settlement', 'settlementUpdate']]);
        $this->middleware('permission:ad-settlement-delete', ['only' => ['destroySettlement']]);
    }

    public function index()
    {
        $ads = Ad::withTrashed()->latest()->get();
        return view('admin.ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'registration_number' => 'required|unique:ads,registration_number',
            'mobile' => 'required|numeric|digits:10'
        ]);
        $input = $request->all();
        $input['branch_id'] = Session::get('branch');
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        Ad::create($input);
        return redirect()->route('ads')->with("success", "Ad Registered Successfully");
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
        $ad = Ad::findOrFail(decrypt($id));
        return view('admin.ads.edit', compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'registration_number' => 'required|unique:ads,registration_number,' . $id,
            'mobile' => 'required|numeric|digits:10'
        ]);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        Ad::findOrFail($id)->update($input);
        return redirect()->route('ads')->with("success", "Ad Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Ad::findOrFail(decrypt($id))->delete();
        return redirect()->back()->with("success", "Ad Registration Deleted Successfully");
    }

    public function settlement(string $id)
    {
        $amount = 0;
        $ad = Ad::findOrFail(decrypt($id));
        $pending = AdSettlement::where('ad_id', $ad->id)->selectRaw("DATEDIFF(now(), created_at) AS pdays")->latest()->first();
        if ($pending) :
            $amount = $pending->pdays * 3.33;
        else :
            $reg = Ad::where('id', $ad->id)->selectRaw("DATEDIFF(now(), created_at) AS pdays")->latest()->firstOrFail();
            $amount = $reg->pdays * 3.33;
        endif;
        $settlements = AdSettlement::where('ad_id', $ad->id)->withTrashed()->latest()->get();
        return view('admin.ads.settlement', compact('ad', 'amount', 'settlements'));
    }

    public function settlementUpdate(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:1',
        ]);
        $input = $request->except(array('registration_number', 'mobile'));
        $input['ad_id'] = decrypt($request->ad_id);
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        AdSettlement::create($input);
        return redirect()->route('ads')->with("success", "Ad settlement updated Successfully");
    }

    public function destroySettlement(string $id)
    {
        AdSettlement::findOrFail(decrypt($id))->delete();
        return redirect()->back()->with("success", "Ad Settlement Deleted Successfully");
    }
}
