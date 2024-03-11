@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="text-success font-weight-bold">Transfer Register - Store</h4>
                        </div>
                        <div class="col-6 text-end"><a href="{{ route('store.transfer.create') }}" class="btn btn-success">ADD NEW</button></a></div>
                    </div>
                    <table id="myTable" class="table display dataTable table-hover table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Transfer ID</th>
                                <th>From Brnach</th>
                                <th>To Branch</th>
                                <th>Tramsfer Date</th>
                                <th>Transfer Note</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transfers as $key => $transfer)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $transfer->id }}</td>
                                <td>{{ $transfer->frombranch?->name ?? 'Main Branch' }}</td>
                                <td>{{ $transfer->tobranch?->name ??  'Main Branch' }}</td>
                                <td>{{ $transfer->created_at->format('d, M Y') }}</td>
                                <td>{{ $transfer->transfer_note }}</td>
                                <td>{!! $transfer->status() !!}
                                <td class="text-center"><a href="{{ ($transfer->purchase_id) ? '#' : route('store.transfer.edit', encrypt($transfer->id)) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                <td class="text-center"><a href="{{ ($transfer->purchase_id) ? '#' :  route('store.transfer.delete', encrypt($transfer->id)) }}" class="{{ ($transfer->purchase_id) ? '' : 'dlt' }}"><i class="fa fa-trash text-danger"></i></a></td>
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