@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Create Ad Registration</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('ad.save'))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-4">
                                <label class="form-label req" for="registration_number">Registration Number</label>
                                {{ html()->text('registration_number', old('registration_number'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Reg. No') }}
                                @error('registration_number')
                                <small class="text-danger">{{ $errors->first('registration_number') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <label class="form-label req" for="mobile">Contact Number</label>
                                {{ html()->text('mobile', old('mobile'))->class('form-control')->attribute('autocomplete', 'false')->maxlength('10')->placeholder('Contact Number') }}
                                @error('mobile')
                                <small class="text-danger">{{ $errors->first('mobile') }}</small>
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