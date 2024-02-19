@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="text-success font-weight-bold">Camp Patient List ({{ $camp->name }})</h4>
                        </div>
                        <div class="col-6 text-end"><a href="{{ route('camp.patient.create', encrypt($camp->id)) }}" class="btn btn-success">ADD NEW</button></a></div>
                    </div>
                    <table id="myTable" class="table display dataTable table-hover table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Patient Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Place</th>
                                <th>Mobile</th>
                                <th>Reg. Date</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patients as $key => $patient)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><a href="{{ route('consultation.create', ['type' => 'Camp', 'review' => 'No', 'type_id' => $patient->id]) }}">{{ $patient->name }}</a></td>
                                <td>{{ $patient->age }}</td>
                                <td>{{ $patient->gender }}</td>
                                <td>{{ $patient->place }}</td>
                                <td>{{ $patient->mobile }}</td>
                                <td>{{ $patient->registration_date->format('d, M Y') }}</td>
                                <td class="text-center"><a href="{{ route('camp.patient.edit', encrypt($patient->id)) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                <td class="text-center"><a href="{{ route('camp.patient.delete', encrypt($patient->id)) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
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