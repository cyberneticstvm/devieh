@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Create Branch</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('branch.save'))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="name">Branch Name</label>
                                {{ html()->text('name', old('name'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Branch Name') }}
                                @error('name')
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label req" for="title">Branch Title</label>
                                {{ html()->text('title', old('title'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Branch Title') }}
                                @error('title')
                                <small class="text-danger">{{ $errors->first('title') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label req" for="code">Branch Code</label>
                                {{ html()->text('code', old('code'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Branch Code') }}
                                @error('code')
                                <small class="text-danger">{{ $errors->first('code') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="gstin">GSTIN</label>
                                {{ html()->text('gstin', old('gstin'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Branch GSTIN') }}
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label req" for="address">Branch Address</label>
                                {{ html()->text('address', old('address'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Branch Address') }}
                                @error('address')
                                <small class="text-danger">{{ $errors->first('address') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="email">Email</label>
                                {{ html()->text('email', old('email'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Email') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="contact_number">Contact Number</label>
                                {{ html()->text('contact_number', old('contact_number'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Contact Number') }}
                                @error('contact_number')
                                <small class="text-danger">{{ $errors->first('contact_number') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label" for="invoice_starts_with">Invoice Start</label>
                                {{ html()->text('invoice_starts_with', old('invoice_starts_with'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Invoice Start') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="invoice_type">Invoice Type</label>
                                {{ html()->select('invoice_type', $itypes, old('invoice_type'))->class('form-control select2')->attribute('autocomplete', 'false')->placeholder('Select') }}
                                @error('invoice_type')
                                <small class="text-danger">{{ $errors->first('invoice_type') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="drug_license_number">Drug License Number</label>
                                {{ html()->text('drug_license_number', old('drug_license_number'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Drug License Number') }}
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label" for="display_capacity">Display Capacity</label>
                                {{ html()->text('display_capacity', old('display_capacity'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Display Capacity') }}
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