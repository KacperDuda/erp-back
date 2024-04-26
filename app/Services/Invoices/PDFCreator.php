<?php

namespace App\Services\Invoices;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf as PdfFacade;
use Barryvdh\DomPDF\PDF;


class PDFCreator
{
    private function __construct(){}

    public static $info = [
        "Nazwa firmy",
        "adres",
        "kod i miasto",
        "NIP 1234567890",
        "nr konta:",
        "12 1212 1212 1212 1212 1212"
    ];

    public static function fromInvoice(
        Invoice $invoice,
        string $type
    ): PDF
    {
        $pdf = self::fromView('invoice.main', [
            'type' => $type,
            'info'=>self::$info,
            'invoice' => $invoice,
            'client' => $invoice->client,
            'fields'=>$invoice->invoiceFields
        ]);
        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }


    public static function fromView($name, $data = null): PDF  {
        return PdfFacade::loadView($name, $data);
    }
}
