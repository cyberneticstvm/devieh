@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Daybook</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('report.daybook.fetch'))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="from_date">From Date</label>
                                {{ html()->date('from_date', $inputs[0])->class('form-control')->attribute('autocomplete', 'false') }}
                                @error('from_date')
                                <small class="text-danger">{{ $errors->first('from_date') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="to_date">To Date</label>
                                {{ html()->date('to_date', $inputs[1])->class('form-control appdate appTime')->attribute('autocomplete', 'false') }}
                                @error('to_date')
                                <small class="text-danger">{{ $errors->first('to_date') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="branch">Branch</label>
                                {{ html()->select($name = 'branch', $value = $branches->pluck('name', 'id'), $inputs[2])->class('form-control')->placeholder('All Branches') }}
                            </div>
                        </div>
                        <div class="py-3 text-end">
                            <button type="button" class="btn btn-danger" onclick="window.history.back()">CANCEL</button>
                            <button type="submit" class="btn btn-submit btn-success">FETCH</button>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                    <div class="card-body table-responsive">
                        <table id="myTable" class="table display dataTable table-hover table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Date</th>
                                    <th>Customer Name</th>
                                    <th>MRN</th>
                                    <th>Branch</th>
                                    <th>Status</th>
                                    <th>Inv.Date</th>
                                    <th>DC</th>
                                    <th>Pharmacy</th>
                                    <th>Advance</th>
                                    <th>Balance</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->mrn }}</td>
                                    <td>{{ $item->bname }}</td>
                                    <td>{{ $item->sname }}</td>
                                    <td>{{ $item->invoice_date }}</td>
                                    <td>{{ $item->consultation_fee }}</td>
                                    <td>{{ $item->total_after_discount }}</td>
                                    <td>{{ $item->advance }}</td>
                                    <td>{{ $item->balance }}</td>
                                    <td>{{ $item->total }}</td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="fw-bold text-primary text-end">Total</td>
                                    <td class="fw-bold text-primary">{{ number_format($data->sum('consultation_fee'), 2) }}</td>
                                    <td class="fw-bold text-primary">{{ number_format($data->sum('total_after_discount'), 2) }}</td>
                                    <td class="fw-bold text-primary">{{ number_format($data->sum('advance'), 2) }}</td>
                                    <td class="fw-bold text-primary">{{ number_format($data->sum('balance'), 2) }}</td>
                                    <td class="fw-bold text-primary">{{ number_format($data->sum('total'), 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection