<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Transfer;
use App\Models\TransferDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:store-transfer-list|store-transfer-create|store-transfer-edit|store-transfer-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:store-transfer-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:store-transfer-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:store-transfer-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $transfers = Transfer::withTrashed()->where('type', 'store')->whereDate('created_at', Carbon::today())->latest()->get();
        return view('admin.transfer.store.index', compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brs = Branch::selectRaw("0 as id, 'Main Branch' as name");
        $branches = Branch::selectRaw("id, name")->union($brs)->orderBy('id')->pluck('name', 'id');
        $products = Product::whereIn('category_id', [3])->pluck('name', 'id');
        return view('admin.transfer.pharmacy.create', compact('branches', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'from_branch' => 'required',
            'to_branch' => 'required|different:from_branch',
        ]);
        try {
            DB::transaction(function () use ($request) {
                $transfer = Transfer::create([
                    'from_branch' => $request->from_branch,
                    'to_branch' => $request->to_branch,
                    'transfer_note' => $request->transfer_note,
                    'type' => 'store',
                    'created_by' => $request->user()->id,
                    'updated_by' => $request->user()->id,
                ]);
                $data = [];
                foreach ($request->product_id as $key => $item) :
                    $data[] = [
                        'transfer_id' => $transfer->id,
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'from_branch' => $request->from_branch,
                        'to_branch' => $request->to_branch,
                        'type' => 'store',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                endforeach;
                TransferDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('store.transfer')->with("success", "Transfer Recorded Successfully");
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
        $transfer = Transfer::findOrFail(decrypt($id));
        $brs = Branch::selectRaw("0 as id, 'Main Branch' as name");
        $branches = Branch::selectRaw("id, name")->union($brs)->orderBy('id')->pluck('name', 'id');
        $products = Product::whereNotIn('category_id', [3])->pluck('name', 'id');
        return view('admin.transfer.store.edit', compact('branches', 'products', 'transfer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'from_branch' => 'required',
            'to_branch' => 'required|different:from_branch',
        ]);
        try {
            DB::transaction(function () use ($request, $id) {
                $transfer = Transfer::findOrFail($id);
                $transfer->update([
                    'from_branch' => $request->from_branch,
                    'to_branch' => $request->to_branch,
                    'transfer_note' => $request->transfer_note,
                    'updated_by' => $request->user()->id,
                ]);
                $data = [];
                foreach ($request->product_id as $key => $item) :
                    $data[] = [
                        'transfer_id' => $transfer->id,
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'from_branch' => $request->from_branch,
                        'to_branch' => $request->to_branch,
                        'type' => 'store',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                endforeach;
                TransferDetail::where('transfer_id', $id)->delete();
                TransferDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('store.transfer')->with("success", "Transfer Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Transfer::findOrFail(decrypt($id))->delete();
        return redirect()->route('store.transfer')->with("success", "Transfer Deleted Successfully");
    }
}
