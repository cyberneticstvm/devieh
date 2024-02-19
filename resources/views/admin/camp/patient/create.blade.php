@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Create Camp Patient ({{ $camp->name }})</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('camp.patient.save'))->class('')->open() }}
                        <input type="hidden" name="camp_id" value="{{ encrypt($camp->id) }}" />
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label req" for="name">Full Name</label>
                                {{ html()->text('name', old('name'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Full Name') }}
                                @error('name')
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <label class="form-label req" for="age">Age</label>
                                {{ html()->text('age', old('age'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('0') }}
                                @error('age')
                                <small class="text-danger">{{ $errors->first('age') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="gender">Gender</label>
                                {{ html()->select($name = 'gender', $value = array('Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'), old('gender'))->class('form-control select2')->placeholder('Select') }}
                                @error('gender')
                                <small class="text-danger">{{ $errors->first('gender') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="mobile">Mobile</label>
                                {{ html()->text('mobile', old('mobile'))->class('form-control')->attribute('autocomplete', 'false')->maxlength(10)->placeholder('Mobile') }}
                                @error('mobile')
                                <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label class="form-label req" for="place">Place</label>
                                {{ html()->text('place', old('place'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Place') }}
                                @error('place')
                                <small class="text-danger">{{ $errors->first('place') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <label class="form-label req" for="registration_date">Registration Date</label>
                                {{ html()->date('registration_date', old('registration_date') ?? date('Y-m-d'))->class('form-control')->attribute('autocomplete', 'false') }}
                                @error('registration_date')
                                <small class="text-danger">{{ $errors->first('registration_date') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-5 col-md-5">
                                <label class="form-label" for="notes">Notes</label>
                                {{ html()->text('notes', old('notes'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Notes') }}
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