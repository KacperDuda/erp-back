<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $rules = [
        'month'=>'required|integer',
        'year' => 'required|digits:4|integer|min:1900',
        'serial'=>'required|integer|gte:0',
        'payment_method'=>'required|string',
        'issuer'=>'required|string',
        'issue_date' => 'required|date_format:Y-m-d',
        'due_date' => 'required|date_format:Y-m-d',
        'is_paid' => 'required|boolean',
        'is_sent' => 'required|boolean',
        'client_id' => 'required|integer',
    ];

    public function __construct()
    {
        $this->authorizeResource(Invoice::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): array
    {
        return ['invoices'=>Invoice::all()];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return [
            'financial_info'=> [
                'net' => $invoice->netPrice(),
                'gross' => $invoice->grossPrice(),
                'tax' => $invoice->tax()
            ],
            'tax_levels'=>$invoice->taxLevels(),
            'invoice' => $invoice,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
