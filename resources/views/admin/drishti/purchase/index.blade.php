@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="text-success font-weight-bold">Drishti Purchase Register</h4>
                        </div>
                        <div class="col-6 text-end"><a href="{{ route('drishti.purchase.create') }}" class="btn btn-success">ADD NEW</button></a></div>
                    </div>
                    <table id="myTable" class="table display dataTable table-hover table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Supplier Name</th>
                                <th>Supplier Invoice</th>
                                <th>Order Date</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchases as $key => $purchase)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $purchase->supplier->name }}</td>
                                <td>{{ $purchase->supplier_invoice }}</td>
                                <td>{{ $purchase->order_date->format('d, M Y') }}</td>
                                <td>{{ $purchase->delivery_date->format('d, M Y') }}</td>
                                <td>{!! $purchase->status() !!}
                                <td class="text-center"><a href="{{ route('drishti.purchase.edit', encrypt($purchase->id)) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                <td class="text-center"><a href="{{ route('drishti.purchase.delete', encrypt($purchase->id)) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
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