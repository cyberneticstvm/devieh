@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Update Camp</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('PUT', route('camp.update', $camp->id))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label req" for="name">Camp Name</label>
                                {{ html()->text('name', $camp->name)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Camp Name') }}
                                @error('name')
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="from_date">From Date</label>
                                {{ html()->date('from_date', $camp->from_date->format('Y-m-d'))->class('form-control appdate appTime')->attribute('autocomplete', 'false') }}
                                @error('from_date')
                                <small class="text-danger">{{ $errors->first('from_date') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="to_date">To Date</label>
                                {{ html()->date('to_date', $camp->to_date->format('Y-m-d'))->class('form-control appdate appTime')->attribute('autocomplete', 'false') }}
                                @error('to_date')
                                <small class="text-danger">{{ $errors->first('to_date') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <label class="form-label req" for="branch_id">Branch <small></small></label>
                                {{ html()->select($name = 'branch_id', $value = $branches->pluck('name', 'id'), $camp->branch_id)->class('form-control select2')->placeholder('Select') }}
                                @error('branch_id')
                                <small class="text-danger">{{ $errors->first('branch_id') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label class="form-label req" for="venue">Venue</label>
                                {{ html()->text('venue', $camp->venue)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Venue') }}
                                @error('venue')
                                <small class="text-danger">{{ $errors->first('venue') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-5 col-md-5">
                                <label class="form-label req" for="address">Address</label>
                                {{ html()->text('address', $camp->address)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Address') }}
                                @error('address')
                                <small class="text-danger">{{ $errors->first('address') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label class="form-label req" for="cordinator">Co-ordinator</label>
                                {{ html()->text('cordinator', $camp->cordinator)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Co-ordinator') }}
                                @error('cordinator')
                                <small class="text-danger">{{ $errors->first('cordinator') }}</small>
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