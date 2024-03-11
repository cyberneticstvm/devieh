@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Create Store Transfer</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('PUT', route('store.transfer.update', $transfer->id))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="from_branch">From Branch</label>
                                {{ html()->select($name = 'from_branch', $value = $branches, $transfer->from_branch)->class('form-control')->placeholder('Select')->attribute('required', 'true') }}
                                @error('from_branch')
                                <small class="text-danger">{{ $errors->first('from_branch') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="to_branch">To Branch</label>
                                {{ html()->select($name = 'to_branch', $value = $branches, $transfer->to_branch)->class('form-control')->placeholder('Select')->attribute('required', 'true') }}
                                @error('to_branch')
                                <small class="text-danger">{{ $errors->first('to_branch') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-3">
                                <label class="form-label" for="transfer_note">Transfer Note</label>
                                {{ html()->text('transfer_note', $transfer->transfer_note)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Transfer Note') }}
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 table-responsive">
                                <table class="table display table-sm">
                                    <thead>
                                        <tr>
                                            <th>PRODUCT</th>
                                            <th>QTY</th>
                                            <th class="text-center"><a href="javascript:void(0)" onclick="addStoreTransferRow()"><i class="fa fa-plus fa-lg text-primary"></i></a></th>
                                        </tr>
                                    </thead>
                                    <tbody class="storeTransferTbl">
                                        @forelse($transfer->details as $key => $item)
                                        <tr>
                                            <td>
                                                {{ html()->select('product_id[]', $products, $item->product_id)->class('form-control select2 pdct')->attribute('id', 'lens1')->attribute('required', 'true')->placeholder('Select') }}
                                            </td>
                                            <td>
                                                {{ html()->number('qty[]', $item->qty, '1', '', '1')->class('text-end form-control')->attribute('required', 'true')->placeholder('0') }}
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="dltRow"><i class="fa fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="py-3 text-end">
                            <button type="button" class="btn btn-danger" onclick="window.history.back()">CANCEL</button>
                            <button type="submit" class="btn btn-submit btn-success">UPDATE</button>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection