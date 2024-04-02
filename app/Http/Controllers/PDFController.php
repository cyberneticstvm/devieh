<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PDFController extends Controller
{
    protected $qrtext;

    function __construct()
    {
        $this->qrtext = "https://devieyecare.com";
    }

    public function opTicket(string $id)
    {
        $mrecord = MedicalRecord::findOrFail(decrypt($id));
        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($this->qrtext));
        $pdf = PDF::loadView('/admin/pdf/opt', compact('mrecord', 'qrcode'));
        return $pdf->stream($mrecord->mrn . '.pdf');
    }

    public function certificate(string $id)
    {
        $mrecord = MedicalRecord::findOrFail(decrypt($id));
        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($this->qrtext));
        $pdf = PDF::loadView('/admin/pdf/certificate', compact('mrecord', 'qrcode'));
        return $pdf->stream('certificate.pdf');
    }

    public function serviceFee(string $id)
    {
        $mrecord = MedicalRecord::findOrFail(decrypt($id));
        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($this->qrtext));
        $pdf = PDF::loadView('/admin/pdf/service-fee', compact('mrecord', 'qrcode'));
        return $pdf->stream('receipt.pdf');
    }

    public function receipt(string $id)
    {
        $mrecord = MedicalRecord::findOrFail(decrypt($id));
        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($this->qrtext));
        $pdf = PDF::loadView('/admin/pdf/receipt', compact('mrecord', 'qrcode'));
        return $pdf->stream('receipt.pdf');
    }
}
