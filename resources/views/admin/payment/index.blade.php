@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row">
                        {{ html()->form('POST', route('payment.fetch'))->open() }}
                        <div class="col-md-4">
                            <label for="SquareInput" class="form-label req">MRN</label>
                            <div class="input-group ">
                                {{ html()->number('mrn', old('mrn'), 1, '', 1)->class("form-control form-control-lg")->placeholder('MRN') }}
                                {{ html()->submit("Fetch Record")->class("btn btn-submit btn-dark btn-lg") }}
                            </div>
                            @error('mrn')
                            <small class="text-danger">{{ $errors->first('mrn') }}</small>
                            @enderror
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                    <div class="row mb-3 mt-5">
                        <div class="col-6">
                            <h4 class="text-success font-weight-bold">Payment List</h4>
                        </div>
                    </div>
                    <table id="myTable" class="table display dataTable table-hover table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>MRN</th>
                                <th>Customer Name</th>
                                <th>Amount</th>
                                <th>Payment Mode</th>
                                <th>Payment Type</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $key => $payment)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $payment->mrecord->mrn }}</td>
                                <td>{{ $payment->mrecord->name }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->pmode->name }}</td>
                                <td>{{ $payment->payment_type }}</td>
                                <td>{{ $payment->notes }}</td>
                                <td>{!! $payment->status() !!}
                                <td class="text-center"><a href="{{ route('payment.edit', encrypt($payment->id)) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                <td class="text-center"><a href="{{ route('payment.delete', encrypt($payment->id)) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
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