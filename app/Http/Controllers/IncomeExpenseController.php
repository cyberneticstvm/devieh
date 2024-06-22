<?php

namespace App\Http\Controllers;

use App\Models\Head;
use App\Models\IncomeExpense;
use App\Models\PaymentMode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IncomeExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:income-expense-list|income-expense-create|income-expense-edit|income-expense-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:income-expense-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:income-expense-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:income-expense-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $iandes = IncomeExpense::withTrashed()->latest()->get();
        return view('admin.iande.index', compact('iandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($category)
    {
        $heads = Head::where('category', $category)->get();
        $pmodes = PaymentMode::all();
        return view('admin.iande.create', compact('heads', 'category', 'pmodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'head_id' => 'required|',
            'amount' => 'required',
            'payment_mode' => 'required',
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        $input['branch_id'] = Session::get('branch');
        IncomeExpense::create($input);
        return redirect()->route('iande')
            ->with('success', 'Record has been created successfully');
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
        $iande = IncomeExpense::findOrFail(decrypt($id));
        $heads = Head::where('category', $iande->head->category)->get();
        $pmodes = PaymentMode::all();
        return view('admin.iande.edit', compact('heads', 'pmodes', 'iande'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'head_id' => 'required|',
            'amount' => 'required',
            'payment_mode' => 'required',
        ]);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        IncomeExpense::findOrFail($id)->update($input);
        return redirect()->route('iande')
            ->with('success', 'Record has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        IncomeExpense::findOrFail(decrypt($id))->delete();
        return redirect()->route('iande')
            ->with('success', 'Record has been deleted successfully');
    }
}
