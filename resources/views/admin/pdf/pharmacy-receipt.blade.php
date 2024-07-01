@extends("admin.pdf.base")
@section("pdfcontent")
<div class="row">
    <div class="col text-center">
        {{ $mrecord->branch->name }}, {{ $mrecord->branch->address }}, {{ $mrecord->branch->contact_number }}
    </div>
    <h4 class="text-center"><u>RECEIPT</u></h4>
    <div class="col">
        <table class="table no-bordered" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="40%">Name: {{ strtoupper($mrecord->name) }}</td>
                    <td>Contact: {{ $mrecord->mobile }}</td>
                    <td>Age: {{ $mrecord->age }}</td>
                </tr>
                <tr>
                    <td>MRN: {{ $mrecord->mrn }}</td>
                    <td>Invoice No: {{ $mrecord->pharmacy->invoice }} </td>
                    <td>Doctor: {{ $mrecord->doctor->name }}</td>
                </tr>
                <tr>
                    <td>Date: {{ $mrecord->created_at->format('d, M Y') }}</td>
                    <td>Due Date: Na</td>
                    <td>Address: {{ $mrecord->place }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <hr style="border: 1px solid; color:red;">
    <table width="100%" class="no-bordered">
        <tr>
            <td>SL No</td>
            <td width="50%">Description of Goods</td>
            <td>HSN/SAC</td>
            <td class="text-end">Rate</td>
            <td class="text-end">Total</td>
        </tr>
        @forelse($mrecord->pharmacy->details as $key => $item)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $item->stock->product->name }}</td>
            <td class="text-center">{{ $item->qty }}</td>
            <td class="text-end">{{ $item->price }}</td>
            <td class="text-end">{{ $item->total }}</td>
        </tr>
        @empty
        @endforelse
        <tr>
            <td colspan="4" class="text-end"><strong>Total</strong></td>
            <td class="text-end fw-bold">{{ number_format($mrecord->pharmacy->details->sum('total'), 2) }}</td>
        </tr>
    </table>
    <p class="mt-50">{{ settings()->toArray()[8]['value'] }}</p>
    <div class="col mt-50 text-center">
        <!--{!! DNS1D::getBarcodeHTML('4445645656', 'UPCA', 2, 50, 'black', true) !!}-->
        <img src="data:image/png;base64, {{ DNS1D::getBarcodePNG($mrecord->mrn, 'C39', 1, 30, array(1, 1, 1), true) }}" alt="barcode" />
    </div>
</div>
<footer>
    <p class="text-center">Created at: {{ $mrecord->created_at->format('d, M Y h:i A') }}, Printed at: {{ \Carbon\Carbon::now()->format('d, M Y h:i A') }}</p>
</footer>
@endsection