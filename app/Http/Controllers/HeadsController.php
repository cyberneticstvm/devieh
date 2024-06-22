<?php

namespace App\Http\Controllers;

use App\Models\Head;
use Illuminate\Http\Request;

class HeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:head-list|head-create|head-edit|head-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:head-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:head-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:head-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $heads = Head::withTrashed()->latest()->get();
        return view('admin.iande.head.index', compact('heads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.iande.head.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:heads,name',
            'category' => 'required',
        ]);
        $input = $request->all();
        Head::create($input);
        return redirect()->route('heads')
            ->with('success', 'Head has been created successfully');
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
        $head = Head::findOrFail(decrypt($id));
        return view('admin.iande.head.edit', compact('head'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:heads,name,' . $id,
            'category' => 'required',
        ]);
        $input = $request->all();
        Head::findOrFail($id)->update($input);
        return redirect()->route('heads')
            ->with('success', 'Head has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Head::findOrFail(decrypt($id))->delete();
        return redirect()->route('heads')
            ->with('success', 'Head has been deleted successfully');
    }
}
