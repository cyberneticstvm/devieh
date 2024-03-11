@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Create Pharmacy Transfer</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('pharmacy.transfer.save'))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="from_branch">From Branch</label>
                                {{ html()->select($name = 'from_branch', $value = $branches, old('from_branch'))->class('form-control')->placeholder('Select')->attribute('required', 'true') }}
                                @error('from_branch')
                                <small class="text-danger">{{ $errors->first('from_branch') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="to_branch">To Branch</label>
                                {{ html()->select($name = 'to_branch', $value = $branches, old('to_branch'))->class('form-control')->placeholder('Select')->attribute('required', 'true') }}
                                @error('to_branch')
                                <small class="text-danger">{{ $errors->first('to_branch') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-3">
                                <label class="form-label" for="transfer_note">Transfer Note</label>
                                {{ html()->text('transfer_note', old('transfer_note'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Transfer Note') }}
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 table-responsive">
                                <table class="table display table-sm">
                                    <thead>
                                        <tr>
                                            <th>PRODUCT</th>
                                            <th>BATCH NUMBER</th>
                                            <th>QTY</th>
                                            <th class="text-center"><a href="javascript:void(0)" onclick="addPharmacyTransferRow()"><i class="fa fa-plus fa-lg text-primary"></i></a></th>
                                        </tr>
                                    </thead>
                                    <tbody class="pharmacyTransferTbl">
                                        <tr>
                                            <td>
                                                {{ html()->select('product_id[]', $products, (old('product_id')) ? old('product_id')[0] : '')->class('form-control select2 pdct')->attribute('id', 'lens1')->attribute('required', 'true')->placeholder('Select') }}
                                            </td>
                                            <td>
                                                {{ html()->text('batch_number[]', (old('batch_number')) ? old('batch_number')[0] : '')->class('form-control')->attribute('required', 'true')->placeholder('Batch Number') }}
                                            </td>
                                            <td>
                                                {{ html()->number('qty[]', (old('qty')) ? old('qty')[0] : '', '1', '', '1')->class('text-end form-control')->attribute('required', 'true')->placeholder('0') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="py-3 text-end">
                            <button type="button" class="btn btn-danger" onclick="window.history.back()">CANCEL</button>
                            <button type="submit" class="btn btn-submit btn-success">SAVE</button>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection