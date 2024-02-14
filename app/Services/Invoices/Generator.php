<?php

namespace App\Services\Invoices;

use App\Models\Entry;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\InvoiceField;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Generator
{
    private function __construct(){}

    public static function invoices(
        int $year,
        int $month,
        string $issuer,
        Carbon $start,
        Carbon $end,
        Carbon $issue_date,
        Carbon $due_date,
        $clients = [], // collection of clients id, empty means all institutional
        bool $fillInvoiceFields = true,
        bool $preventEmptyInvoices = true
    )
    {
        if(empty($clients)) {
            // all companies
            $clients = Client::where('is_company', true)->get();
        } else {
            // all specified (including private)
            $clients = Client::whereIn('id', $clients)->get();
        }

        $invoice_collection = collect([]);

        foreach ($clients as $client) { // no ->each due to many variables to use

            $invoice = Invoice::create([
                'month' => $month,
                'year' => $year,
                'serial' => Invoice::nextSerial($year),
                'payment_method' => 'bank_transfer',
                'issuer' => $issuer,
                'issue_date' => $issue_date,
                'due_date' => $due_date,
                'is_paid' => false,
                'is_sent' => false,
                'client_id' => $client->id,
            ]);

            if ($fillInvoiceFields) {
                self::invoiceFields($start, $end, $invoice);
            }

            if($invoice->invoiceFields->isEmpty() && $preventEmptyInvoices) {
                $invoice->delete();
            } else {
                $invoice_collection->add($invoice);
            }
        }

        return $invoice_collection;
    }

    public static function invoiceFields(
        Carbon $start,
        Carbon $end,
        Invoice $invoice
    )
    {
        // we have completed invoice, now only create fields
        Entry                                                          // we want entries
        ::where('client_id', $invoice->client_id)                      // with a proper client
        ->whereBetween('posting_date', [$start->format('Y-m-d'), $end->format('Y-m-d')])                 // within a given date range
        ->get()                                                        // retrieve from DB
        ->groupBy(['product_id', 'unit_price', 'vat'])                 // each invoice field is composed with entries that belong to these groups
        ->flatten(2)                                                   // grouping adds unnecessary 2 layers
        ->each(function ($group) use ($invoice)                        // now summing amount from each entry
        {
            $totalAmount = $group->sum('amount');
            $vat = $group[0]->vat;                                     // vat is same between all entries in a group
            $product = Product::findOrFail($group[0]->product_id);     // product too
            $unit_price = $group[0]->unit_price;                       // unit price too

            InvoiceField::create([                                     // saving field to DB
                'invoice_id'=>$invoice->id,
                'product_name'=>$product->name,
                'amount'=>$totalAmount,
                'unit_price'=>$unit_price,
                'vat'=>$vat
            ]);
        });
    }


}
