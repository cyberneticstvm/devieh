@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Create Pharmacy Purchase</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('pharmacy.purchase.save'))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label req" for="name">Supplier Name</label>
                                {{ html()->select('supplier_id', $suppliers, old('supplier_id'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Select') }}
                                @error('supplier_id')
                                <small class="text-danger">{{ $errors->first('supplier_id') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="order_date">Order Date</label>
                                {{ html()->date('order_date', old('order_date') ?? date('Y-m-d'))->class('form-control')->attribute('autocomplete', 'false') }}
                                @error('order_date')
                                <small class="text-danger">{{ $errors->first('order_date') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="delivery_date">Delivery Date</label>
                                {{ html()->date('delivery_date', old('delivery_date') ?? date('Y-m-d'))->class('form-control')->attribute('autocomplete', 'false') }}
                                @error('delivery_date')
                                <small class="text-danger">{{ $errors->first('delivery_date') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label req" for="supplier_invoice">Supplier Invoice</label>
                                {{ html()->text('supplier_invoice', old('supplier_invoice'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Supplier Invoice') }}
                                @error('supplier_invoice')
                                <small class="text-danger">{{ $errors->first('supplier_invoice') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label" for="notes">Notes / Remarks</label>
                                {{ html()->text('notes', old('notes'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Notes / Remarks') }}
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 table-responsive">
                                <table class="table display table-sm">
                                    <thead>
                                        <tr>
                                            <th>PRODUCT</th>
                                            <th>QTY</th>
                                            <th>BATCH NUMBER</th>
                                            <th width="15%">EXPIRY DATE</th>
                                            <th>PURCHASE PRICE</th>
                                            <th>SELLING PRICE</th>
                                            <th class="text-center"><a href="javascript:void(0)" onclick="addPharmacyPurchaseRow()"><i class="fa fa-plus fa-lg text-primary"></i></a></th>
                                        </tr>
                                    </thead>
                                    <tbody class="pharmacyPurchaseTbl">
                                        <tr>
                                            <td>
                                                {{ html()->select('product_id[]', $products, (old('product_id')) ? old('product_id')[0] : '')->class('form-control select2')->attribute('required', 'true')->placeholder('Select') }}
                                            </td>
                                            <td>
                                                {{ html()->number('qty[]', (old('qty')) ? old('qty')[0] : '', $min=1, '', $step='1')->class('text-end form-control')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0') }}
                                            </td>
                                            <td>
                                                {{ html()->text('batch_number[]', (old('batch_number')) ? old('batch_number')[0] : '')->class('form-control')->attribute('autocomplete', 'false')->maxlength('40')->placeholder('Batch Number') }}
                                            </td>
                                            <td>
                                                {{ html()->date('expiry_date[]', (old('expiry_date')) ? old('expiry_date')[0] : date('Y-m-d'))->class('form-control w-100')->attribute('autocomplete', 'false') }}
                                            </td>
                                            <td>
                                                {{ html()->number('purchase_price[]', (old('purchase_price')) ? old('purchase_price')[0] : '', $min=0, '', $step='any')->class('text-end form-control')->attribute('autocomplete', 'false')->placeholder('0.00') }}
                                            </td>
                                            <td>
                                                {{ html()->number('selling_price[]', (old('selling_price')) ? old('selling_price')[0] : '', $min=1, '', $step='any')->class('text-end form-control')->attribute('autocomplete', 'false')->placeholder('0.00') }}
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