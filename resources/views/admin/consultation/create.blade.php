@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">New Registration</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('consultation.save'))->class('')->open() }}
                        <input type="hidden" name="type" value="{{ $type }}" />
                        <input type="hidden" name="review" value="{{ $review }}" />
                        <input type="hidden" name="type_id" value="{{ $type_id }}" />
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label req" for="name">Full Name</label>
                                {{ html()->text('name', $patient?->name ?? old('name'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Full Name') }}
                                @error('name')
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <label class="form-label req" for="age">Age</label>
                                {{ html()->text('age', $patient?->age ?? old('age'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('0') }}
                                @error('age')
                                <small class="text-danger">{{ $errors->first('age') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="gender">Gender</label>
                                {{ html()->select($name = 'gender', $value = array('Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'), $patient?->gender ?? old('gender'))->class('form-control select2')->placeholder('Select Gender') }}
                                @error('gender')
                                <small class="text-danger">{{ $errors->first('gender') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="mobile">Mobile</label>
                                {{ html()->text('mobile', $patient?->mobile ?? old('mobile'))->class('form-control')->attribute('autocomplete', 'false')->maxlength(10)->placeholder('Mobile') }}
                                @error('mobile')
                                <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label req" for="place">Place</label>
                                {{ html()->text('place', $patient?->place ?? old('place'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Place') }}
                                @error('place')
                                <small class="text-danger">{{ $errors->first('place') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="doctor_id">Doctor</label>
                                {{ html()->select($name = 'doctor_id', $value = $doctors->pluck('name', 'id'), $patient?->doctor_id ?? old('doctor_id'))->class('form-control')->placeholder('Select Doctor') }}
                                @error('doctor_id')
                                <small class="text-danger">{{ $errors->first('doctor_id') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="purpose_of_visit">Purpose of Visit</label>
                                {{ html()->select($name = 'purpose_of_visit', $value = array('License' => 'License', 'Consultation' => 'Consultation'), old('purpose_of_visit'))->class('form-control')->placeholder('Select') }}
                                @error('purpose_of_visit')
                                <small class="text-danger">{{ $errors->first('purpose_of_visit') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="cataract_surgery_advised">Cataract Surgery Advised?</label>
                                {{ html()->select($name = 'cataract_surgery_advised', $value = array('Yes' => 'Yes', 'No' => 'No'), old('cataract_surgery_advised'))->class('form-control')->placeholder('Select') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="cataract_surgery_urgent">Cataract Surgery Urgent?</label>
                                {{ html()->select($name = 'cataract_surgery_urgent', $value = array('Yes' => 'Yes', 'No' => 'No'), old('cataract_surgery_urgent'))->class('form-control')->placeholder('Select') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="consultation_fee_payment_mode">DC Payment Mode</label>
                                {{ html()->select($name = 'consultation_fee_payment_mode', $value = $pmodes->pluck('name', 'id'), old('consultation_fee_payment_mode'))->class('form-control')->placeholder('Select') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="post_review_date">Post Review Date</label>
                                {{ html()->date('post_review_date', old('post_review_date') ?? date('Y-m-d'))->class('form-control')->attribute('autocomplete', 'false') }}
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