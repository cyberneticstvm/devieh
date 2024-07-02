@extends("admin.pdf.base")
@section("pdfcontent")
<div class="row">
    <div class="col text-center">
        {{ $mrecord->branch->name }}, {{ $mrecord->branch->address }}, {{ $mrecord->branch->contact_number }}
    </div>
    <h4 class="text-center"><u>INVOICE</u></h4>
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
                    <td>Ref & DC: Na </td>
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
    <table width="100%" class="no-bordered">
        <tr>
            <td colspan="6">
                <hr style="border: 1px solid; color:red;">
            </td>
        </tr>
        <tr>
            <td>Eye</td>
            <td>Thick</td>
            <td width="50%">Product</td>
            <td class="text-center">HSN/SAC</td>
            <td class="text-center">Qty</td>
            <td class="text-end">Price</td>
        </tr>
        <tr>
            <td colspan="6">
                <hr style="border: 1px solid; color:red;">
            </td>
        </tr>
        @forelse($mrecord->order->details as $key => $item)
        <tr>
            <td>{{ $item->eye }}</td>
            <td>{{ $item->thick }}</td>
            <td>{{ $item->stock->product->name }}</td>
            <td></td>
            <td class="text-center">{{ $item->qty }}</td>
            <td class="text-end">{{ $item->price }}</td>
        </tr>
        @empty
        @endforelse
        <tr>
            <td colspan="5" class="text-end">Total</td>
            <td class="text-end fw-bold">{{ $mrecord->order->total }}</td>
        </tr>
        <tr>
            <td colspan="5" class="text-end">Discount</td>
            <td class="text-end fw-bold">{{ $mrecord->order->discount }}</td>
        </tr>
        <tr>
            <td colspan="5" class="text-end">Advance</td>
            <td class="text-end fw-bold">{{ $mrecord->order->advance }}</td>
        </tr>
        <tr>
            <td colspan="5" class="text-end">Balance</td>
            <td class="text-end fw-bold">{{ $mrecord->order->balance }}</td>
        </tr>
    </table>
    <p class="">Phone: <strong>0470 2624622 / 8089424622 </strong> {{ settings()->toArray()[8]['value'] }}</p>
    <hr style="border: 1px dotted; color:blue;">
    <div class="col mt-50 text-center">
        <!--{!! DNS1D::getBarcodeHTML('4445645656', 'UPCA', 2, 50, 'black', true) !!}-->
        <img src="data:image/png;base64, {{ DNS1D::getBarcodePNG($mrecord->mrn, 'C39', 1, 30, array(1, 1, 1), true) }}" alt="barcode" />
    </div>
</div>
<footer>
    <p class="text-center">Created at: {{ $mrecord->created_at->format('d, M Y h:i A') }}, Printed at: {{ \Carbon\Carbon::now()->format('d, M Y h:i A') }}</p>
</footer>
@endsection