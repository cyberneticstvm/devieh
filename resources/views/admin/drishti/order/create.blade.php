@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Create Drishti Order</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('drishti.order.save'))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label req" for="customer_id">Customer</label>
                                {{ html()->select($name = 'customer_id', $value = $customers->pluck('name', 'id'), old('customer_id'))->class('form-control select2')->placeholder('Select')->attribute('required', 'true') }}
                                @error('customer_id')
                                <small class="text-danger">{{ $errors->first('customer_id') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label" for="sale_note">Order Note</label>
                                {{ html()->text('sale_note', old('sale_note'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Order Note') }}
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 table-responsive">
                                <table class="table display table-sm">
                                    <thead>
                                        <tr>
                                            <th width="30%">PRODUCT</th>
                                            <th width="10%">BATCH</th>
                                            <th>EXPIRY</th>
                                            <th>QTY</th>
                                            <th>FREE QTY</th>
                                            <th>PRICE</th>
                                            <th>TOTAL</th>
                                            <th class="text-center"><a href="javascript:void(0)" onclick="addDrishtiOrderRow()"><i class="fa fa-plus fa-lg text-primary"></i></a></th>
                                        </tr>
                                    </thead>
                                    <tbody class="powerbox">
                                        <tr>
                                            <td>
                                                {{ html()->select('product_id[]', $products->pluck('name', 'id'), (old('product_id')) ? old('product_id')[0] : '')->class('form-control select2 pdct')->attribute('id', 'pdct1')->attribute('required', 'true')->placeholder('Select') }}
                                            </td>
                                            <td>
                                                {{ html()->text('batch_number[]', (old('batch_number')) ? old('batch_number')[0] : '')->class('form-control')->attribute('autocomplete', 'false')->maxlength('40')->placeholder('Batch') }}
                                            </td>
                                            <td>
                                                {{ html()->date('expiry_date[]', (old('expiry_date')) ? old('expiry_date')[0] : '')->class('form-control')->attribute('autocomplete', 'false') }}
                                            </td>
                                            <td>
                                                {{ html()->number('qty[]', (old('qty')) ? old('qty')[0] : '')->class('form-control w-100 text-end qty')->attribute('autocomplete', 'false')->placeholder('0') }}
                                            </td>
                                            <td>
                                                {{ html()->number('qty_free[]', (old('qty_free')) ? old('qty_free')[0] : '')->class('form-control w-100 text-end')->attribute('autocomplete', 'false')->placeholder('0') }}
                                            </td>
                                            <td>
                                                {{ html()->text('price[]', (old('price')) ? old('price')[0] : '')->class('form-control text-end price')->attribute('autocomplete', 'false')->placeholder('0.0')->attribute('readonly', 'true') }}
                                            </td>
                                            <td>
                                                {{ html()->text('tot[]', (old('tot')) ? old('tot')[0] : '')->class('border-0 form-control text-end tot')->attribute('autocomplete', 'false')->placeholder('0.0')->attribute('readonly', 'true') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" class="text-end">Total</td>
                                            <td>
                                                {{ html()->text('total', old('total'))->class('border-0 form-control text-end total')->attribute('autocomplete', 'false')->placeholder('0.0')->attribute('readonly', 'true') }}
                                                @error('total')
                                                <small class="text-danger">{{ $errors->first('total') }}</small>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-end">Discount</td>
                                            <td>
                                                {{ html()->text('discount', old('discount') ?? '0.00')->class('border-0 form-control text-end discount')->attribute('autocomplete', 'false')->placeholder('0.00') }}
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-end">Balance</td>
                                            <td>
                                                {{ html()->text('balance', old('balance'))->class('border-0 form-control text-end balance')->attribute('autocomplete', 'false')->placeholder('0.0')->attribute('readonly', 'true') }}
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
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