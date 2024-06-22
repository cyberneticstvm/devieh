@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Update Head</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('PUT', route('head.update', $head->id))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label req" for="name">Head Name</label>
                                {{ html()->text('name', $head->name)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Category Name') }}
                                @error('name')
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label req" for="name">Head Categry</label>
                                {{ html()->select('category', array('Income' => 'Income', 'Expense' => 'Expense', 'Other' => 'Other'), $head->category)->class('form-control select2')->placeholder('Select') }}
                                @error('category')
                                <small class="text-danger">{{ $errors->first('category') }}</small>
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