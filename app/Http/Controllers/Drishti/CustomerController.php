<?php

namespace App\Http\Controllers\Drishti;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\State;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:customer-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:customer-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $customers = Customer::withTrashed()->latest()->get();
        return view('admin.drishti.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = State::all();
        return view('admin.drishti.customer.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'contact_person_name' => 'required',
            'contact_person_number' => 'required',
            'state' => 'required',
            'delivery_method' => 'required',
            'credit_limit' => 'required',
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        Customer::create($input);
        return redirect()->route('customer') . with("success", "Customer created successfully");
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
        $customer = Customer::findOrFail(decrypt($id));
        $states = State::all();
        return view('admin.drishti.customer.edit', compact('states', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'contact_person_name' => 'required',
            'contact_person_number' => 'required',
            'state' => 'required',
            'delivery_method' => 'required',
            'credit_limit' => 'required',
        ]);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        Customer::findOrFail($id)->update($input);
        return redirect()->route('customer')->with("success", "Customer updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Customer::findOrFail(decrypt($id))->delete();
        return redirect()->route('customer')->with("success", "Customer deleted successfully");
    }
}
