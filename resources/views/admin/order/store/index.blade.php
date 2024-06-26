@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="text-success font-weight-bold">Store Order Register</h4>
                        </div>
                    </div>
                    <table id="myTable" class="table display dataTable table-hover table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>MRN</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Place</th>
                                <th>Invoice Number</th>
                                <th>Order Status</th>
                                <th>Status</th>
                                <th>Receipt</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $key => $order)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $order->mrecord->mrn }}</td>
                                <td>{{ $order->mrecord->name }}</td>
                                <td>{{ $order->mrecord->mobile }}</td>
                                <td>{{ $order->mrecord->place }}</td>
                                <td>{!! $order->invoice(encrypt($order->id)) !!}</td>
                                <td>{{ $order->orderstatus->name }}</td>
                                <td>{!! $order->status() !!}</td>
                                <td class="text-center"><a href="{{ route('pdf.receipt', encrypt($order->medical_record_id)) }}" target="_blank"><i class="fa fa-file-pdf-o text-danger"></i></a></td>
                                <td class="text-center"><a href="{{ route('store.order.edit', encrypt($order->id)) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                <td class="text-center"><a href="{{ route('store.order.delete', encrypt($order->id)) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
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