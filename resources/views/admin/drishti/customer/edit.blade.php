@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Update Customer</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('PUT', route('drishti.customer.update', $customer->id))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label req" for="name">Name</label>
                                {{ html()->text('name', $customer->name)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Customer Name') }}
                                @error('name')
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="contact_number">Contact Number</label>
                                {{ html()->text('contact_number', $customer->contact_number)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Contact Number') }}
                                @error('contact_number')
                                <small class="text-danger">{{ $errors->first('contact_number') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="email">Email</label>
                                {{ html()->email('email', $customer->email)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Email') }}
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label req" for="address">Address</label>
                                {{ html()->text('address', $customer->address)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Address') }}
                                @error('address')
                                <small class="text-danger">{{ $errors->first('address') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="contact_person_name">Contact Person Name</label>
                                {{ html()->text('contact_person_name', $customer->contact_person_name)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Contact Person Name') }}
                                @error('contact_person_name')
                                <small class="text-danger">{{ $errors->first('contact_person_name') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="contact_person_number">Contact Person Number</label>
                                {{ html()->text('contact_person_number', $customer->contact_person_number)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Contact Person Number') }}
                                @error('contact_person_number')
                                <small class="text-danger">{{ $errors->first('contact_person_number') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label" for="drug_license_number">Drug License Number</label>
                                {{ html()->text('drug_license_number', $customer->drug_license_number)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Drug License Number') }}
                                @error('drug_license_number')
                                <small class="text-danger">{{ $errors->first('drug_license_number') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="state">State</label>
                                {{ html()->select('state', $states->pluck('name', 'id'), $customer->state)->class('form-control select2')->placeholder('Select')->required() }}
                                @error('state')
                                <small class="text-danger">{{ $errors->first('state') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="delivery_method">Delivery Method</label>
                                {{ html()->select('delivery_method', dMethods(), $customer->delivery_method)->class('form-control select2')->attribute('autocomplete', 'false')->placeholder('Select') }}
                                @error('delivery_method')
                                <small class="text-danger">{{ $errors->first('delivery_method') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="credit_limit">Credit Limit</label>
                                {{ html()->number('credit_limit', $customer->credit_limit)->class('form-control')->attribute('autocomplete', 'false')->placeholder('0.00') }}
                                @error('credit_limit')
                                <small class="text-danger">{{ $errors->first('credit_limit') }}</small>
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