@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Create Appointment</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('appointment.save'))->class('')->attribute('id', 'frmAppointment')->open() }}
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
                                {{ html()->select($name = 'gender', $value = array('Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'), old('gender'))->class('form-control select2')->placeholder('Select Gender') }}
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
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label req" for="place">Place</label>
                                {{ html()->text('place', old('place'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Place') }}
                                @error('place')
                                <small class="text-danger">{{ $errors->first('place') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="branch_id">Branch</label>
                                {{ html()->select($name = 'branch_id', $value = $branches->pluck('name', 'id'), old('branch_id'))->class('form-control appbranch appTime')->placeholder('Select Branch') }}
                                @error('branch_id')
                                <small class="text-danger">{{ $errors->first('branch_id') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="doctor_id">Doctor</label>
                                {{ html()->select($name = 'doctor_id', $value = $doctors->pluck('name', 'id'), old('doctor_id'))->class('form-control appdoctor appTime')->placeholder('Select Doctor') }}
                                @error('doctor_id')
                                <small class="text-danger">{{ $errors->first('doctor_id') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="date">Appointment Date</label>
                                {{ html()->date('date', old('date') ?? date('Y-m-d'))->class('form-control appdate appTime')->attribute('autocomplete', 'false') }}
                                @error('date')
                                <small class="text-danger">{{ $errors->first('date') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label req">Appointment Time</label>
                                {{ html()->select($name = 'time', $value = NULL, NULL)->class('form-control select2 selAppTime')->placeholder('Select') }}
                                @error('time')
                                <small class="text-danger">{{ $errors->first('time') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="old_mrn">Old MRN</label>
                                {{ html()->text('old_mrn', old('old_mrn'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Old MRN') }}
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