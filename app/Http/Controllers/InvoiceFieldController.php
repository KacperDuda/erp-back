<?php

namespace App\Http\Controllers;

use App\Models\InvoiceField;
use Illuminate\Http\Request;

class InvoiceFieldController extends Controller
{
    protected $rules = [
        'invoice_id'=>'required|integer',
        'product_name'=>'required|string',
        'amount'=>'required|integer',
        'unit_price'=>'required|integer',
        'vat'=>'required|numeric',
    ];
    public function __construct()
    {
        $this->authorizeResource(InvoiceField::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(InvoiceField $invoiceField)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceField $invoiceField)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceField $invoiceField)
    {
        //
    }
}
