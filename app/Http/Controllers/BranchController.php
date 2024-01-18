<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Setting;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $itypes;

    public function __construct()
    {
        $this->itypes = Setting::where('key', 'invoice_type')->pluck('value', 'id');

        $this->middleware('permission:branch-list|branch-create|branch-edit|branch-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:branch-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:branch-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:branch-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $branches = Branch::withTrashed()->latest()->get();
        return view('admin.branch.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $itypes = $this->itypes;
        return view('admin.branch.create', compact('itypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:branches,name',
            'title' => 'required|unique:branches,title',
            'code' => 'required|unique:branches,code',
            'address' => 'required',
            'contact_number' => 'required',
            'invoice_type' => 'required',
        ]);
        $input = $request->all();
        Branch::create($input);
        return redirect()->route('branch')->with("success", "Branch created successfully");
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
        $itypes = $this->itypes;
        $branch = Branch::findOrFail(decrypt($id));
        return view('admin.branch.edit', compact('itypes', 'branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:branches,name,' . $id,
            'title' => 'required|unique:branches,title,' . $id,
            'code' => 'required|unique:branches,code,' . $id,
            'address' => 'required',
            'contact_number' => 'required',
            'invoice_type' => 'required',
        ]);
        $input = $request->all();
        Branch::findOrFail($id)->update($input);
        return redirect()->route('branch')->with("success", "Branch updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Branch::findOrFail(decrypt($id))->delete();
        return redirect()->route('branch')->with("success", "Branch deleted successfully");
    }
}
