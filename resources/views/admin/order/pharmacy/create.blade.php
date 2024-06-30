@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Create Pharmacy Order</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('pharmacy.order.save', $mrecord->id))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-3">
                                <label class="form-label" for="mrn">MRN</label>
                                {{ html()->text('name', $mrecord->mrn)->class('form-control')->attribute('autocomplete', 'false')->attribute('readonly', 'true') }}
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <label class="form-label" for="name">Patient Name</label>
                                {{ html()->text('name', $mrecord->name)->class('form-control')->attribute('autocomplete', 'false')->attribute('readonly', 'true') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="payment_mode">Payment Mode</label>
                                {{ html()->select($name = 'payment_mode', $value = $pmodes->pluck('name', 'id'), $order?->payment_mode ?? '')->class('form-control')->placeholder('Select')->attribute('required', 'true') }}
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 table-responsive">
                                <table class="table display table-sm ordTbl">
                                    <thead>
                                        <tr>
                                            <th>PRODUCT</th>
                                            <th>QTY</th>
                                            <th>BATCH</th>
                                            <th>DOSAGE</th>
                                            <th>DURATION</th>
                                            <th>PRICE</th>
                                            <th>TOTAL</th>
                                            <th class="text-center"><a href="javascript:void(0)" data-branch="" onclick=addPharmacyOrderRow("{{ Session::get('branch') }}")><i class="fa fa-plus fa-lg text-primary"></i></a></th>
                                        </tr>
                                    </thead>
                                    <tbody class="powerbox">
                                        <tr>
                                            <td>
                                                {{ html()->select('product_id[]', $products->pluck('name', 'id'), (old('product_id')) ? old('product_id')[0] : '')->class('form-control select2 pdct')->attribute('id', 'lens1')->attribute('required', 'true')->placeholder('Select') }}
                                            </td>
                                            <td>
                                                {{ html()->text('qty[]', (old('qty')) ? old('qty')[0] : 1)->class('text-end qty')->attribute('autocomplete', 'false')->placeholder('0')->attribute('readonly') }}
                                            </td>
                                            <td>
                                                {{ html()->text('batch_number[]', (old('batch_number')) ? old('batch_number')[0] : '')->class('form-control w-100')->attribute('autocomplete', 'false')->maxlength('40')->placeholder('Batch') }}
                                            </td>
                                            <td>
                                                {{ html()->text('dosage[]', (old('dosage')) ? old('dosage')[0] : '')->class('form-control w-100')->attribute('autocomplete', 'false')->placeholder('Dosage') }}
                                            </td>
                                            <td>
                                                {{ html()->text('duration[]', (old('duration')) ? old('duration')[0] : '')->class('form-control')->attribute('autocomplete', 'false')->placeholder('Duration') }}
                                            </td>
                                            <td>
                                                {{ html()->text('price[]', (old('price')) ? old('price')[0] : '')->class('text-end price')->attribute('autocomplete', 'false')->placeholder('0.0')->attribute('readonly', 'true') }}
                                            </td>
                                            <td>
                                                {{ html()->text('tot[]', (old('tot')) ? old('tot')[0] : '')->class('text-end tot')->attribute('autocomplete', 'false')->placeholder('0.0')->attribute('readonly', 'true') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" class="text-end">Total</td>
                                            <td>
                                                {{ html()->text('total', old('total'))->class('text-end total')->attribute('autocomplete', 'false')->placeholder('0.0')->attribute('readonly', 'true') }}
                                                @error('total')
                                                <small class="text-danger">{{ $errors->first('total') }}</small>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-end">Discount</td>
                                            <td>
                                                {{ html()->text('discount', old('discount') ?? '0.00')->class('text-end discount')->attribute('autocomplete', 'false')->placeholder('0.00') }}
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-end">Balance</td>
                                            <td>
                                                {{ html()->text('balance', old('balance'))->class('text-end balance')->attribute('autocomplete', 'false')->placeholder('0.0')->attribute('readonly', 'true') }}
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