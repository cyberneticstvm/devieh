@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Create Doctor</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('doctor.save'))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label req" for="name">Doctor Name</label>
                                {{ html()->text('name', old('name'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Branch Name') }}
                                @error('name')
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label req" for="code">Doctor Code</label>
                                {{ html()->text('code', old('code'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Branch Code') }}
                                @error('code')
                                <small class="text-danger">{{ $errors->first('code') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="registartion_number">Registration Number</label>
                                {{ html()->text('registartion_number', old('registartion_number'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Registration Number') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="email">Email</label>
                                {{ html()->text('email', old('email'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Email') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="contact_number">Contact Number</label>
                                {{ html()->text('contact_number', old('contact_number'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Contact Number') }}
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label" for="fee">Fee</label>
                                {{ html()->text('fee', old('fee'))->class('form-control')->attribute('autocomplete', 'false')->maxlength('7')->placeholder('0.00') }}
                                @error('fee')
                                <small class="text-danger">{{ $errors->first('fee') }}</small>
                                @enderror
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