@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="text-success font-weight-bold">Adv. Registration Register</h4>
                        </div>
                        <div class="col-6 text-end"><a href="{{ route('ad.create') }}" class="btn btn-success">ADD NEW</button></a></div>
                    </div>
                    <table id="myTable" class="table display dataTable table-hover table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Registration Number</th>
                                <th>Contact Number</th>
                                <th>Registered Date</th>
                                <th>Branch</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ads as $key => $ad)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><a href="{{ route('ad.settlement', encrypt($ad->id)) }}">{{ $ad->registration_number }}</a></td>
                                <td>{{ $ad->mobile }}</td>
                                <td>{{ $ad->created_at->format('d, M Y') }}</td>
                                <td>{{ $ad->branch->name }}</td>
                                <td>{!! $ad->status() !!}
                                <td class="text-center"><a href="{{ route('ad.edit', encrypt($ad->id)) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                <td class="text-center"><a href="{{ route('ad.delete', encrypt($ad->id)) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
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