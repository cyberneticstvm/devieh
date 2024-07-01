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
            <td colspan="5">
                <hr style="border: 1px solid; color:red;">
            </td>
        </tr>
        <tr>
            <td>Eye</td>
            <td>Thick</td>
            <td width="50%">Product</td>
            <td class="text-center">Qty</td>
            <td class="text-end">Price</td>
        </tr>
        <tr>
            <td colspan="5">
                <hr style="border: 1px solid; color:red;">
            </td>
        </tr>
        @forelse($mrecord->order->details as $key => $item)
        <tr>
            <td>{{ $item->eye }}</td>
            <td>{{ $item->thick }}</td>
            <td>{{ $item->stock->product->name }}</td>
            <td class="text-center">{{ $item->qty }}</td>
            <td class="text-end">{{ $item->price }}</td>
        </tr>
        @empty
        @endforelse
        <tr>
            <td colspan="4" class="text-end">Total</td>
            <td class="text-end fw-bold">{{ $mrecord->order->total }}</td>
        </tr>
        <tr>
            <td colspan="4" class="text-end">Discount</td>
            <td class="text-end fw-bold">{{ $mrecord->order->discount }}</td>
        </tr>
        <tr>
            <td colspan="4" class="text-end">Advance</td>
            <td class="text-end fw-bold">{{ $mrecord->order->advance }}</td>
        </tr>
        <tr>
            <td colspan="4" class="text-end">Balance</td>
            <td class="text-end fw-bold">{{ $mrecord->order->balance }}</td>
        </tr>
    </table>
    <p class="">Phone: <strong>0470 2624622 / 8089424622</strong> Please bring this slip at the time of delivery/ Please note that we will not responsible for any damage while fitting the lens on customer's frame / To be billed after approval / In case of any complaints or suggestions please call 99 95 27 30 40.</p>
    <hr style="border: 1px dotted; color:blue;">
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
    <div class="col mt-10">
        <table class="table bordered" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td>Eye</td>
                    <td>Sph</td>
                    <td>Cyl</td>
                    <td>Axis</td>
                    <td>Add</td>
                    <td>Dia</td>
                    <td>Thick</td>
                    <td>Ipd</td>
                    <td width="40%">Product</td>
                    <td>Qty</td>
                </tr>
                @forelse($mrecord->order->details as $key => $item)
                <tr>
                    <td class="text-center">{{ $item->eye }}</td>
                    <td class="text-center">{{ $item->sph }}</td>
                    <td class="text-center">{{ $item->cyl }}</td>
                    <td class="text-center">{{ $item->axis }}</td>
                    <td class="text-center">{{ $item->add }}</td>
                    <td class="text-center">{{ $item->dia }}</td>
                    <td>{{ $item->thick }}</td>
                    <td>{{ $item->ipd }}</td>
                    <td>{{ $item->stock->product->name }}</td>
                    <td>{{ $item->qty }}</td>
                </tr>
                @empty
                @endforelse
                <tr>
                    <td colspan="10">
                        Remarks: {{ $mrecord->order->remarks }}, Pdct.Adv: {{ $mrecord->order->padvisor?->name }}<br />
                    </td>
                </tr>
                <tr>
                    <td>FWC:</td>
                    <td>{{ ($mrecord->order->fwc) ? 'Yes' : '' }}</td>
                    <td>HDL:</td>
                    <td>{{ ($mrecord->order->hdl) ? 'Yes' : '' }}</td>
                    <td>NOA:</td>
                    <td>{{ ($mrecord->order->noa) ? 'Yes' : '' }}</td>
                    <td>URG:</td>
                    <td>{{ ($mrecord->order->urg) ? 'Yes' : '' }}</td>
                    <td>TPC:</td>
                    <td>{{ ($mrecord->order->tpc) ? 'Yes' : '' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col mt-50 text-center">
        <!--{!! DNS1D::getBarcodeHTML('4445645656', 'UPCA', 2, 50, 'black', true) !!}-->
        <img src="data:image/png;base64, {{ DNS1D::getBarcodePNG($mrecord->mrn, 'C39', 1, 30, array(1, 1, 1), true) }}" alt="barcode" />
    </div>
</div>
<footer>
    <p class="text-center">Created at: {{ $mrecord->created_at->format('d, M Y h:i A') }}, Printed at: {{ \Carbon\Carbon::now()->format('d, M Y h:i A') }}</p>
</footer>
@endsection