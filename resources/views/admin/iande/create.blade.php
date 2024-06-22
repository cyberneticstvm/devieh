@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Create {{ $category }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('iande.save'))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label req" for="name">Head</label>
                                {{ html()->select('head_id', $heads->pluck('name', 'id'), old('head_id'))->class('form-control select2')->attribute('autocomplete', 'false')->placeholder('Select') }}
                                @error('head_id')
                                <small class="text-danger">{{ $errors->first('head_id') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label req" for="title">Amount</label>
                                {{ html()->number('amount', old('amount'), 1, '', 'any')->class('form-control')->attribute('autocomplete', 'false')->placeholder('0.00') }}
                                @error('amount')
                                <small class="text-danger">{{ $errors->first('amount') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label req" for="name">Payment Mode</label>
                                {{ html()->select('payment_mode', $pmodes->pluck('name', 'id'), old('head_id'))->class('form-control select2')->attribute('autocomplete', 'false')->placeholder('Select') }}
                                @error('payment_mode')
                                <small class="text-danger">{{ $errors->first('payment_mode') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label" for="display_capacity">Description</label>
                                {{ html()->text('description', old('description'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Description') }}
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