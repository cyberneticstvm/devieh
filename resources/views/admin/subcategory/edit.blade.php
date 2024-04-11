@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Update Subcategory</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('PUT', route('subcategory.update', $subcategory->id))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label req" for="name">Subcategory Name</label>
                                {{ html()->text('name', $subcategory->name)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Category Name') }}
                                @error('name')
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label req" for="category_id">Category</label>
                                {{ html()->select($name = 'category_id', $value = $categories->pluck('name', 'id'), $subcategory->category_id)->class('form-control select2')->placeholder('Select Category') }}
                                @error('category_id')
                                <small class="text-danger">{{ $errors->first('category_id') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <label class="form-label" for="hsn">HSN</label>
                                {{ html()->text('hsn', $subcategory->hsn)->class('form-control')->attribute('autocomplete', 'false')->placeholder('HSN') }}
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