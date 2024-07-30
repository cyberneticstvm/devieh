@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="text-success font-weight-bold">Product Unique List</h4>
                        </div>
                    </div>
                    <table id="myTable" class="table display dataTable table-hover table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th>Product Unique Code</th>
                                <th>Price</th>
                                <th>Category Name</th>
                                <th>Subcategory Name</th>
                                <th>Barcode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $key => $product)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $product->product?->name }}</td>
                                <td>{{ $product->product?->code }}</td>
                                <td>{{ $product->unique_pcode }}</td>
                                <td>{{ $product->product?->price }}</td>
                                <td>{{ $product->product?->category?->name }}</td>
                                <td>{{ $product->product?->subcategory?->name }}</td>
                                <td class="text-center"><a href="{{ route('product.unique.barcode', encrypt($product->id)) }}">View</a></td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection