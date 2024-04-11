@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Update Product</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('PUT', route('drishti.item.update', $product->id))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label req" for="name">Product Name</label>
                                {{ html()->text('name', $product->name)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Product Name') }}
                                @error('name')
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label req" for="category_id">Category</label>
                                {{ html()->select($name = 'category_id', $value = $categories->pluck('name', 'id'), $product->category_id)->class('form-control select2')->placeholder('Select Category') }}
                                @error('category_id')
                                <small class="text-danger">{{ $errors->first('category_id') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label req" for="subcategory_id">Subcategory</label>
                                {{ html()->select($name = 'subcategory_id', $value = $subcategories->pluck('name', 'id'), $product->subcategory_id)->class('form-control select2')->placeholder('Select Subcategory') }}
                                @error('subcategory_id')
                                <small class="text-danger">{{ $errors->first('subcategory_id') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label req" for="price">Price</label>
                                {{ html()->text('price', $product->price)->class('form-control')->attribute('autocomplete', 'false')->maxlength('7')->placeholder('0.0') }}
                                @error('price')
                                <small class="text-danger">{{ $errors->first('price') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label" for="description">Descripton</label>
                                {{ html()->text('description', $product->description)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Description') }}
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