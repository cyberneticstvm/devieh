<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Camp;
use Illuminate\Http\Request;

class CampController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:camp-list|camp-create|camp-edit|camp-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:camp-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:camp-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:camp-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $camps = Camp::withTrashed()->latest()->get();
        return view('admin.camp.index', compact('camps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        return view('admin.camp.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:camps,name',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'branch_id' => 'required',
            'venue' => 'required',
            'address' => 'required',
            'cordinator' => 'required',
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        Camp::create($input);
        return redirect()->route('camp')->with('success', 'Camp has been created successfully!');
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
        $camp = Camp::findOrFail(decrypt($id));
        $branches = Branch::all();
        return view('admin.camp.edit', compact('branches', 'camp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:camps,name,' . $id,
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'branch_id' => 'required',
            'venue' => 'required',
            'address' => 'required',
            'cordinator' => 'required',
        ]);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        Camp::findOrFail($id)->update($input);
        return redirect()->route('camp')->with('success', 'Camp has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Camp::findOrFail(decrypt($id))->delete();
        return redirect()->route('camp')->with('success', 'Camp has been deleted successfully!');
    }
}
