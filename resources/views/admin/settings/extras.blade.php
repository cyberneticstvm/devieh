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