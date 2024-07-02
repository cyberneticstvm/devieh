@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Extra Settings</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('settings.extras.save'))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-2 col-md-4">
                                <label class="form-label req" for="name">Appointment Start</label>
                                {{ html()->time('appointment_start_time', old('appointment_start_time') ?? $settings[1]['value'])->class('form-control') }}
                                @error('appointment_start_time')
                                <small class="text-danger">{{ $errors->first('appointment_start_time') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <label class="form-label req" for="name">Appointment End</label>
                                {{ html()->time('appointment_end_time', old('appointment_end_time') ?? $settings[2]['value'])->class('form-control') }}
                                @error('appointment_end_time')
                                <small class="text-danger">{{ $errors->first('appointment_end_time') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="">Appointment Duration in Minutes</label>
                                {{ html()->number('appointment_interval', old('appointment_interval') ?? $settings[3]['value'], 1, '', 'any')->class('form-control')->placeholder('0') }}
                                @error('appointment_interval')
                                <small class="text-danger">{{ $errors->first('appointment_interval') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="">Consultation Fee Waived in Days</label>
                                {{ html()->number('consultation_free_days', old('appointment_interval') ?? $settings[0]['value'], 1, '', 'any')->class('form-control')->placeholder('0') }}
                                @error('consultation_free_days')
                                <small class="text-danger">{{ $errors->first('consultation_free_days') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <label class="form-label req" for="">Restrict Date for Delivery</label>
                                {{ html()->date('restrict_date_for_delivery', old('restrict_date_for_delivery') ?? $settings[4]['value'])->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="">Daily Expense Limit</label>
                                {{ html()->number('daily_expense_limit', old('daily_expense_limit') ?? $settings[5]['value'], 0, '', 'any')->class('form-control')->placeholder('0') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="">Advisor Commission Level</label>
                                {{ html()->number('advisor_commission_level', old('advisor_commission_level') ?? $settings[6]['value'], 0, '', 'any')->class('form-control')->placeholder('0') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="">Invoice Due Amount Limit</label>
                                {{ html()->number('invloice_due_amount_limit', old('invloice_due_amount_limit') ?? $settings[7]['value'], 0, '', 'any')->class('form-control')->placeholder('0') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="">Products Delivery per Day</label>
                                {{ html()->number('products_delivery_per_day', old('products_delivery_per_day') ?? $settings[8]['value'], 0, '', 'any')->class('form-control')->placeholder('0') }}
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