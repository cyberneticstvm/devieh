@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Search</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('search.fetch'))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-4">
                                <label class="form-label req" for="search_by">Search By</label>
                                {{ html()->select('search_by', array('name' => 'Name', 'mobile' => 'Mobile', 'mrn' => 'MRN'), old('search_by') ?? $inputs[0])->class('form-control select2')->attribute('autocomplete', 'false')->placeholder('Select') }}
                                @error('search_by')
                                <small class="text-danger">{{ $errors->first('search_by') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label class="form-label req" for="search_term">Search Term</label>
                                {{ html()->text('search_term', old('search_term') ?? $inputs[1])->class('form-control')->attribute('autocomplete', 'false')->placeholder('Search Term') }}
                                @error('search_term')
                                <small class="text-danger">{{ $errors->first('search_term') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <label class="form-label req" for="search_condition">Search Condition</label>
                                {{ html()->select('search_condition', array('exact' => 'Exact Match'), old('search_condition') ?? $inputs[2])->class('form-control select2')->attribute('autocomplete', 'false')->placeholder('Select') }}
                                @error('search_condition')
                                <small class="text-danger">{{ $errors->first('search_condition') }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="py-3 text-end">
                            <button type="button" class="btn btn-danger" onclick="window.history.back()">CANCEL</button>
                            <button type="submit" class="btn btn-submit btn-success">SEARCH</button>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <table id="myTable" class="table display dataTable table-hover table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Review</th>
                                <th>Order</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Place</th>
                                <th>Medicine</th>
                                <th>Receipt</th>
                                <th>Invoice</th>
                                <th>GAC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><a href="{{ route('consultation.create', ['type' => 'Direct', 'review' => 'Yes', 'type_id' => 0]) }}">Review</a></td>
                                <td><a href="{{ route('store.order.edit', encrypt($item?->order?->id)) }}">{{ $item->mrn }}</a></td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->mobile }}</td>
                                <td>{{ $item->place }}</td>
                                <td><a href="{{ route('pdf.pharmacy.receipt', encrypt($item->id)) }}" target="_blank"><i class="fa fa-file-pdf-o text-danger"></i></a></td>
                                <td><a href="{{ route('pdf.receipt', encrypt($item->id)) }}" target="_blank"><i class="fa fa-file-pdf-o text-danger"></i></a></td>
                                <td>{!! $item->order->invoice(encrypt($item?->order?->id)) !!}</td>
                                <td>{{ $item?->order?->auth_code }}</td>
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