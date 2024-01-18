@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="text-success font-weight-bold">Doctor List</h4>
                        </div>
                        <div class="col-6 text-end"><a href="{{ route('doctor.create') }}" class="btn btn-success">ADD NEW</button></a></div>
                    </div>
                    <table id="myTable" class="table display dataTable table-hover table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Doctor Name</th>
                                <th>Code</th>
                                <th>Reg. Number</th>
                                <th>Contact Number</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($doctors as $key => $doctor)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $doctor->name }}</td>
                                <td>{{ $doctor->code }}</td>
                                <td>{{ $doctor->registartion_number }}</td>
                                <td>{{ $doctor->contact_number }}</td>
                                <td>{!! $doctor->status() !!}
                                <td class="text-center"><a href="{{ route('doctor.edit', encrypt($doctor->id)) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                <td class="text-center"><a href="{{ route('doctor.delete', encrypt($doctor->id)) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
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