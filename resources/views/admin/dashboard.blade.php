@extends("admin.base")
@section("content")
<!-- Body: Body -->
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="text-success font-weight-bold">Appointment List</h4>
                        </div>
                        <div class="col-6 text-end"><a href="{{ route('appointment.create') }}" class="btn btn-success">ADD NEW</button></a></div>
                    </div>
                    <table id="myTable" class="table display dataTable table-hover table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Place</th>
                                <th>Phone Number</th>
                                <th>Doctor</th>
                                <th>Branch</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $key => $appointment)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><a href="/admin/consultation/create/Appointment/{{$appointment->isReview()}}/{{$appointment->id}}">{{ $appointment->name }}</a></td>
                                <td>{{ $appointment->age }}</td>
                                <td>{{ $appointment->place }}</td>
                                <td>{{ $appointment->mobile }}</td>
                                <td>{{ $appointment->doctor->name }}</td>
                                <td>{{ $appointment->branch->name }}</td>
                                <td>{{ $appointment->date->format('d, M Y') }}</td>
                                <td>{{ $appointment->time->format('h:i A') }}</td>
                                <td>{!! $appointment->status() !!}
                                <td class="text-center"><a href="{{ route('appointment.edit', encrypt($appointment->id)) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                <td class="text-center"><a href="{{ route('appointment.delete', encrypt($appointment->id)) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- .row end -->
    </div>
</div>
@if(!Session::has('branch'))
<div class="modal fade" id="branchSelector" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="branchSelector" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-toggle-wrapper">
                    <h4 class="text-center pb-2">Select Branch!</h4>
                    <form method="post" action="{{ route('user.branch.update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                {{ html()->select($name = 'branch', $value = $branches, NULL)->class('form-control')->placeholder('Select Branch')->required() }}
                                @error('branches')
                                <small class="text-danger">{{ $errors->first('branches') }}</small>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-secondary d-flex m-auto mt-3 btn-submit" type="submit">Update Branch</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection