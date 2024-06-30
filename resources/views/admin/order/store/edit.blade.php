@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Update Order</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('PUT', route('store.order.update', $order->id))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-3">
                                <label class="form-label" for="mrn">MRN</label>
                                {{ html()->text('name', $mrecord->mrn)->class('form-control')->attribute('autocomplete', 'false')->attribute('readonly', 'true') }}
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <label class="form-label" for="name">Patient Name</label>
                                {{ html()->text('name', $mrecord->name)->class('form-control')->attribute('autocomplete', 'false')->attribute('readonly', 'true') }}
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <label class="form-label" for="cataract_surgery_advised">Cataract Surgery Advised?</label>
                                {{ html()->select($name = 'cataract_surgery_advised', $value = array('Yes' => 'Yes', 'No' => 'No'), $mrecord->cataract_surgery_advised)->class('form-control')->placeholder('Select') }}
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <label class="form-label" for="cataract_surgery_urgent">Cataract Surgery Urgent?</label>
                                {{ html()->select($name = 'cataract_surgery_urgent', $value = array('Yes' => 'Yes', 'No' => 'No'), $mrecord->cataract_surgery_urgent)->class('form-control')->placeholder('Select') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="consultation_fee_payment_mode">DC Payment Mode</label>
                                {{ html()->select($name = 'consultation_fee_payment_mode', $value = $pmodes->pluck('name', 'id'), $mrecord->consultation_fee_payment_mode)->class('form-control')->placeholder('Select') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="product_advisor">Product Advisor</label>
                                {{ html()->select($name = 'product_advisor', $value = $advisors->pluck('name', 'id'), $order->product_advisor)->class('form-control')->placeholder('Select') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="case_type">Case Type</label>
                                {{ html()->select($name = 'case_type', $value = casetypes(), $order->case_type)->class('form-control')->placeholder('Select') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="post_review_date">Post Review Date</label>
                                {{ html()->date('post_review_date', $mrecord->post_review_date ? $mrecord->post_review_date->format('Y-m-d') : '' )->class('form-control')->attribute('autocomplete', 'false') }}
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <label class="form-label" for="remarks">Notes / Remarks</label>
                                {{ html()->text('remarks', $order->remarks)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Notes / Remarks') }}
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-2 col-md-4">
                                <div class="form-check">
                                    {{
                                        html()->checkbox('fwx', $order->fwc)->class('form-check-input')->attribute('id', 'fwc')
                                    }}
                                    <label class="form-check-label" for="fwc">
                                        FWC
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <div class="form-check">
                                    {{
                                        html()->checkbox('hdl', $order->hdl)->class('form-check-input')->attribute('id', 'hdl')
                                    }}
                                    <label class="form-check-label" for="hdl">
                                        HDL
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <div class="form-check">
                                    {{
                                        html()->checkbox('noa', $order->noa)->class('form-check-input')->attribute('id', 'noa')
                                    }}
                                    <label class="form-check-label" for="noa">
                                        NOA
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <div class="form-check">
                                    {{
                                        html()->checkbox('urg', $order->urg)->class('form-check-input')->attribute('id', 'urg')
                                    }}
                                    <label class="form-check-label" for="urg">
                                        URG
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <div class="form-check">
                                    {{
                                        html()->checkbox('tpc', $order->tpc)->class('form-check-input')->attribute('id', 'tpc')
                                    }}
                                    <label class="form-check-label" for="tpc">
                                        3PC
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 table-responsive">
                                <table class="table display table-sm ordTbl">
                                    <thead>
                                        <tr>
                                            <th class="d-none"></th>
                                            <th>EYE</th>
                                            <th>SPH</th>
                                            <th>CYL</th>
                                            <th>AXIS</th>
                                            <th>ADD</th>
                                            <th>DIA</th>
                                            <th width="15%">THICK</th>
                                            <th>IPD</th>
                                            <th width="25%">PRODUCT</th>
                                            <th>QTY</th>
                                            <th>PRICE</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody class="powerbox">
                                        @forelse($order->details as $key => $item)
                                        <tr>
                                            <td class="d-none"><input type="hidden" name="product_type[]" value="{{ $item->product_type }}" /></td>
                                            <td>
                                                {{ html()->text('eye[]', $item->eye)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder($item->eye ?? 'Frame')->attribute('readonly', 'true') }}
                                            </td>
                                            <td>
                                                @if($item->product_type == 'Lens')
                                                {{ html()->text('sph[]', $item->sph)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0.0') }}
                                                @else
                                                {{ html()->hidden('sph[]', $item->sph)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0.0') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->product_type == 'Lens')
                                                {{ html()->text('cyl[]', $item->cyl)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0.0') }}
                                                @else
                                                {{ html()->hidden('cyl[]', $item->cyl)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0.0') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->product_type == 'Lens')
                                                {{ html()->text('axis[]', $item->axis)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0.0') }}
                                                @else
                                                {{ html()->hidden('axis[]', $item->axis)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0.0') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->product_type == 'Lens')
                                                {{ html()->text('add[]', $item->add)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0.0') }}
                                                @else
                                                {{ html()->hidden('add[]', $item->add)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0.0') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->product_type == 'Lens')
                                                {{ html()->text('dia[]', $item->dia)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0.0') }}
                                                @else
                                                {{ html()->hidden('dia[]', $item->dia)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0.0') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->product_type == 'Lens')
                                                {{ html()->text('thick[]', $item->thick)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0.0') }}
                                                @else
                                                {{ html()->hidden('thick[]', $item->thick)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0.0') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->product_type == 'Lens')
                                                {{ html()->text('ipd[]', $item->ipd)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0.0') }}
                                                @else
                                                {{ html()->hidden('ipd[]', $item->ipd)->class('')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0.0') }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ html()->select('product_id[]', $products->whereIn('cid', ($item->product_type == 'Lens') ? [2, 4] : 1)->pluck('name', 'id'), $item->product_id)->class('form-control select2 pdct')->attribute('id', 'lens'.$item->id)->attribute('autocomplete', 'false')->placeholder('Select') }}
                                            </td>
                                            <td>
                                                {{ html()->text('qty[]', $item->qty)->class('text-end qty')->attribute('autocomplete', 'false')->maxlength('6')->placeholder('0') }}
                                            </td>
                                            <td>
                                                {{ html()->text('price[]', $item->price)->class('text-end price')->attribute('autocomplete', 'false')->placeholder('0.0')->attribute('readonly', 'true') }}
                                            </td>
                                            <td>
                                                {{ html()->text('tot[]', $item->total)->class('text-end tot')->attribute('autocomplete', 'false')->placeholder('0.0')->attribute('readonly', 'true') }}
                                            </td>
                                        </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                    <tfoot style="border-top: 5px solid #4DCA88;">
                                        <tr>
                                            <td colspan="11" class="text-end">Total</td>
                                            <td>
                                                {{ html()->text('total', $order->total)->class('text-end total')->attribute('autocomplete', 'false')->placeholder('0.0')->attribute('readonly', 'true') }}
                                                @error('total')
                                                <small class="text-danger">{{ $errors->first('total') }}</small>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="11" class="text-end">Discount</td>
                                            <td>
                                                {{ html()->text('discount', $order->discount ?? '0.00')->class('text-end discount')->attribute('autocomplete', 'false')->placeholder('0.00') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" class="text-end">Advance Payment Mode</td>
                                            <td colspan="2">
                                                {{ html()->select('advance_payment_mode', $pmodes->pluck('name', 'id'), $order->advance_payment_mode)->class('form-control')->attribute('autocomplete', 'false')->attribute('id', 'pmode1')->placeholder('Select') }}
                                                @error('advance_payment_mode')
                                                <small class="text-danger">{{ $errors->first('advance_payment_mode') }}</small>
                                                @enderror
                                            </td>
                                            <td class="text-end">Advance</td>
                                            <td>
                                                {{ html()->text('advance', $order->advance ?? '0.00')->class('text-end advance')->attribute('autocomplete', 'false')->placeholder('0.0') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" class="text-end">Balance Payment Mode</td>
                                            <td colspan="2">
                                                {{ html()->select('balance_payment_mode', $pmodes->pluck('name', 'id'), $order->balance_payment_mode)->class('form-control')->attribute('autocomplete', 'false')->attribute('id', 'pmode2')->placeholder('Select') }}
                                            </td>
                                            <td class="text-end">Balance</td>
                                            <td>
                                                {{ html()->text('balance', $order->balance)->class('text-end balance')->attribute('autocomplete', 'false')->placeholder('0.0')->attribute('readonly', 'true') }}
                                            </td>
                                        </tr>
                                    </tfoot>
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