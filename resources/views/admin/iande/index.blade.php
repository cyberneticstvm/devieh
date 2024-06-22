@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="text-success font-weight-bold">Income & Expenses List</h4>
                        </div>
                        <div class="col-6 text-end">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Add New</button>
                                <ul class="dropdown-menu border-0 shadow bg-primary">
                                    <li><a class="dropdown-item text-light" href="{{ route('iande.create', 'Expense') }}">Expense</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-light" href="{{ route('iande.create', 'Income') }}">Income</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <table id="myTable" class="table display dataTable table-hover table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Head Name</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Payment Mode</th>
                                <th>Description</th>
                                <th>Branch</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($iandes as $key => $iande)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $iande->head->name }}</td>
                                <td>{{ $iande->head->category }}</td>
                                <td>{{ $iande->amount }}</td>
                                <td>{{ $iande->pmode->name }}</td>
                                <td>{{ $iande->description }}</td>
                                <td>{{ $iande->branch->name }}</td>
                                <td>{!! $iande->status() !!}
                                <td class="text-center"><a href="{{ route('iande.edit', encrypt($iande->id)) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                <td class="text-center"><a href="{{ route('iande.delete', encrypt($iande->id)) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
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