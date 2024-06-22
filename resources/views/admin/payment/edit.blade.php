@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Update Payment</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('PUT', route('payment.update', $payment->id))->class('')->open() }}
                        <input type="hidden" name="medical_record_id" value="{{ encrypt($payment->medical_record_id) }}" />
                        <input type="hidden" name="balance" value="{{ $payment->amount }}" />
                        <div class="row g-3">
                            <div class="row g-3">
                                <div class="col-lg-2 col-md-6">
                                    <label class="form-label req" for="title">Amount</label>
                                    {{ html()->number('amount', $payment->amount, 1, '', 'any')->class('form-control')->attribute('autocomplete', 'false')->placeholder('0.00') }}
                                    @error('amount')
                                    <small class="text-danger">{{ $errors->first('amount') }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <label class="form-label req" for="name">Payment Mode</label>
                                    {{ html()->select('payment_mode', $pmodes->pluck('name', 'id'), $payment->payment_mode)->class('form-control select2')->attribute('autocomplete', 'false')->placeholder('Select') }}
                                    @error('payment_mode')
                                    <small class="text-danger">{{ $errors->first('payment_mode') }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <label class="form-label req" for="type">Payment Type</label>
                                    {{ html()->select('payment_type', array('Partial' => 'Partial', 'Balance' => 'Balance'), $payment->payment_type)->class('form-control select2')->attribute('autocomplete', 'false')->placeholder('Select') }}
                                    @error('payment_type')
                                    <small class="text-danger">{{ $errors->first('payment_type') }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <label class="form-label" for="notes">Notes</label>
                                    {{ html()->text('notes', $payment->notes)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Notes') }}
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