<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:pharmacy-order-list|pharmacy-order-create|pharmacy-order-edit|pharmacy-order-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:pharmacy-order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pharmacy-order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pharmacy-order-delete', ['only' => ['destroy']]);
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
