@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="text-success font-weight-bold">Consultation List</h4>
                        </div>
                        <div class="col-6 text-end"><a href="{{ route('consultation.create', ['type' => 'Direct', 'review' => 'No', 'type_id' => 0]) }}" class="btn btn-success">ADD NEW</button></a></div>
                    </div>
                    <table id="myTable" class="table display dataTable table-hover table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>MRN</th>
                                <th>Name</th>
                                <th>Place</th>
                                <th>Phone Number</th>
                                <th>Doctor</th>
                                <th>OPT</th>
                                <th>Service Fee</th>
                                <th>Receipt</th>
                                <th>Status</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($consultations as $key => $consultation)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $consultation->mrn }}</td>
                                <td>{{ $consultation->name }}</td>
                                <td>{{ $consultation->place }}</td>
                                <td>{{ $consultation->mobile }}</td>
                                <td>{{ $consultation->doctor->name }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{!! $consultation->status() !!}
                                <td class="text-center"><a href="{{ route('consultation.edit', encrypt($consultation->id)) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                <td class="text-center"><a href="{{ route('consultation.delete', encrypt($consultation->id)) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
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