@extends("admin.pdf.base")
@section("pdfcontent")
<div class="row">
    <div class="col text-center">
        {{ $mrecord->branch->name }}, {{ $mrecord->branch->address }}, {{ $mrecord->branch->contact_number }}
    </div>
    <h4 class="text-center"><u>OUT PATIENT RECORD</u></h4>
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
                    <td colspan="2">Doctor: {{ $mrecord->doctor->name }}</td>
                </tr>
                <tr>
                    <td>Date: {{ $mrecord->created_at->format('d, M Y') }}</td>
                    <td colspan="2">Address: {{ $mrecord->place }}</td>
                </tr>
            </tbody>
        </table>
        <!--<hr style="border: 1px solid; color:red;">-->
    </div>
    <div class="col mt-10">
        <table class="table" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td colspan="2">
                        History
                        <pre />
                        <pre />
                        <pre />
                    </td>
                </tr>
                <tr>
                    <td>
                        RE
                        <pre />
                        <pre />
                        <pre />
                        <pre />
                    </td>
                    <td>
                        LE
                        <pre />
                        <pre />
                        <pre />
                        <pre />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col mt-10">
        <p>Codes: BS, CNR, DCT, DIL, DS, EPLN, FB, I&C, IOP, LIC-LV, PB, PSR, RS, RW, VT</p>
        <table class="table" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td colspan="2">
                        Provisional Diagnosis/Treatment
                        <pre />
                        <pre />
                        <pre />
                        <pre />
                        <pre />
                        <pre />
                        <pre />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col mt-10 text-center">
        <!--{!! DNS1D::getBarcodeHTML('4445645656', 'UPCA', 2, 50, 'black', true) !!}-->
        <img src="data:image/png;base64, {{ DNS1D::getBarcodePNG($mrecord->mrn, 'C39', 1, 30, array(1, 1, 1), true) }}" alt="barcode" />
    </div>
</div>
<footer>
    <p class="text-center">Created at: {{ $mrecord->created_at->format('d, M Y h:i A') }}, Printed at: {{ \Carbon\Carbon::now()->format('d, M Y h:i A') }}</p>
</footer>
@endsection