@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Proceed Payment</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-5">
                            <div class="col fw-bold">
                                MRN: {{ $mrecord->mrn }}
                            </div>
                            <div class="col fw-bold">
                                Customer Name: {{ $mrecord->name }}
                            </div>
                            <div class="col fw-bold text-danger">
                                Balance Amount: {{ number_format($balance, 2) }}
                            </div>
                        </div>
                        <div class="py-3 text-end">
                            <button type="button" class="btn btn-danger" onclick="window.history.back()">CANCEL</button>
                            <a href="{{ route('payment.create', encrypt($mrecord->id)) }}" class="btn btn-submit btn-success">PROCEED</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection