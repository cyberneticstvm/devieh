<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PharmacyPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:pharmacy-purchase-list|pharmacy-purchase-create|pharmacy-purchase-edit|pharmacy-purchase-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:pharmacy-purchase-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pharmacy-purchase-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pharmacy-purchase-delete', ['only' => ['destroy']]);
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
