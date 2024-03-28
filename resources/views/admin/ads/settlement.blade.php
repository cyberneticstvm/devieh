@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Ad Settlement</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('PUT', route('ad.settlement.update', $ad->id))->class('')->open() }}
                        <input type="hidden" name="ad_id" value="{{ encrypt($ad->id) }}" />
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-4">
                                <label class="form-label req" for="registration_number">Registration Number</label>
                                {{ html()->text('registration_number', $ad->registration_number)->class('form-control')->attribute('autocomplete', 'false')->attribute('readonly', 'true') }}
                                @error('registration_number')
                                <small class="text-danger">{{ $errors->first('registration_number') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <label class="form-label req" for="mobile">Contact Number</label>
                                {{ html()->text('mobile', $ad->mobile)->class('form-control')->attribute('autocomplete', 'false')->maxlength('10')->attribute('readonly', 'true') }}
                                @error('mobile')
                                <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <label class="form-label req" for="amount">Amount</label>
                                {{ html()->number('amount', $amount, '', '', '')->class('form-control')->attribute('autocomplete', 'false')->attribute('readonly', 'true')->placeholder('0.00') }}
                                @error('amount')
                                <small class="text-danger">{{ $errors->first('amount') }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="py-3 text-end">
                            <button type="button" class="btn btn-danger" onclick="window.history.back()">CANCEL</button>
                            <button type="submit" class="btn btn-submit btn-success">UPDATE</button>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="text-success font-weight-bold">Settlements for {{ $ad->registration_number }}</h4>
                        </div>
                    </div>
                    <table id="myTable" class="table display dataTable table-hover table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Amount</th>
                                <th>Paid Date</th>
                                <th>Status</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($settlements as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->amount }}</td>
                                <td>{{ $item->created_at->format('d, M Y') }}</td>
                                <td>{!! $item->status() !!}
                                <td class="text-center"><a href="{{ route('ad.settlement.delete', encrypt($item->id)) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
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