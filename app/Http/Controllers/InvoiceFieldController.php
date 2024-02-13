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
        // we receive fields with invoice - no need to implement to
        throw new \Exception("Method GET /invoiceFields not implemented");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return ['invoice_field' => InvoiceField::create(
            $request->validate($this->rules)
        )];
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceField $invoiceField)
    {
        throw new \Exception("Method GET /invoiceFields/{id} not implemented");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceField $invoiceField)
    {
        $invoiceField->fill($request->validate($this->rules));
        $invoiceField->save();
        return ['invoice_field' => $invoiceField];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        InvoiceField::destroy($id);
        return ['message'=>'ok'];
    }
}
