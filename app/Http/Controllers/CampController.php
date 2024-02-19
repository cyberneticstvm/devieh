<?php

namespace App\Http\Controllers;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
