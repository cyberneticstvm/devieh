<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Order;
use App\Models\Sale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Exception;
use PhpParser\Node\Stmt\Catch_;
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
        $pdf = PDF::loadView('admin.pdf.service-fee', compact('mrecord', 'qrcode'));
        return $pdf->stream('service-fee.pdf');
    }

    public function receipt(string $id)
    {
        $mrecord = MedicalRecord::findOrFail(decrypt($id));
        if ($mrecord->order?->details) :
            $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($this->qrtext));
            $pdf = PDF::loadView('admin.pdf.receipt', compact('mrecord', 'qrcode'));
            $pdf->output();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->set_opacity(.2);
            $canvas->page_text($width / 2.5, $height / 1.3, 'LAB COPY', null, 40, array(0, 0, 0), 2, 2, -40);
            return $pdf->stream('receipt.pdf');
        else :
            return redirect()->back()->with("error", "No order found!");
        endif;
    }

    public function invoice(string $oid)
    {
        $order = Order::findOrFail(decrypt($oid));
        $mrecord = MedicalRecord::findOrFail($order->medical_record_id);
        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($this->qrtext));
        $pdf = PDF::loadView('admin.pdf.invoice', compact('order', 'qrcode', 'mrecord'));
        return $pdf->stream('invoice.pdf');
    }

    public function pharmacyReceipt(string $id)
    {
        $mrecord = MedicalRecord::findOrFail(decrypt($id));
        if ($mrecord->pharmacy?->details) :
            $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($this->qrtext));
            $pdf = PDF::loadView('admin.pdf.pharmacy-receipt', compact('mrecord', 'qrcode'));
            return $pdf->stream('pharmacy-receipt.pdf');
        else :
            return redirect()->back()->with("error", "No order found!");
        endif;
    }

    public function drishtiOrderInvoice(string $id)
    {
        $order = Sale::findOrFail(decrypt($id));
        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($this->qrtext));
        $pdf = PDF::loadView('/admin/drishti/pdf/invoice', compact('order', 'qrcode'));
        return $pdf->stream('invoice.pdf');
    }
}
