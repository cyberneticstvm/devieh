@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Update Supplier</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('PUT', route('supplier.update', $supplier->id))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label req" for="name">Supplier Name</label>
                                {{ html()->text('name', $supplier->name)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Supplier Name') }}
                                @error('name')
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="contact_number">Contact Number</label>
                                {{ html()->text('contact_number', $supplier->contact_number)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Contact Number') }}
                                @error('contact_number')
                                <small class="text-danger">{{ $errors->first('contact_number') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-5 col-md-6">
                                <label class="form-label req" for="address">Address</label>
                                {{ html()->text('address', $supplier->address)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Address') }}
                                @error('address')
                                <small class="text-danger">{{ $errors->first('address') }}</small>
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