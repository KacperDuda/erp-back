<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\Invoices\Generator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $rules = [
        'month'=>'required|integer',
        'year' => 'required|digits:4|integer|min:1900',
        'serial'=>'nullable|integer|gte:0',
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
        $data = $request->validate($this->rules);
        $data['serial'] = $data['serial'] ?: Invoice::nextSerial($data['year']);
        return ['invoice' => Invoice::create($data)];
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
    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules);
        $invoice = Invoice::findOrFail($id);
        $invoice->fill($data);
        $invoice->save();
        return ['invoice' => $invoice];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice): array
    {
        $invoice->delete();
        return['message'=>'ok'];
    }

    // generate invoice
    public function generate(Request $request): array
    {
        $data = $request->validate([
            'month'=>'required|integer',
            'year' => 'required|digits:4|integer|min:1900',
            'payment_method'=>'required|string',
            'issuer'=>'required|string',
            'issue_date' => 'required|date_format:Y-m-d',
            'due_date' => 'required|date_format:Y-m-d',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'client_id' => 'nullable|array',
            'client_id.*' => 'integer'
        ]);

        return ['invoices' => Generator::invoices(
            year: $data['year'],
            month: $data['month'],
            issuer: $data['issuer'],
            start: Carbon::createFromFormat('Y-m-d', $data['start_date'])->setHour(0)->setMinute(0)->setSecond(0),
            end: Carbon::createFromFormat('Y-m-d', $data['end_date'])->setHour(23)->setMinute(59)->setSecond(59),
            issue_date: Carbon::createFromFormat('Y-m-d', $data['issue_date']),
            due_date: Carbon::createFromFormat('Y-m-d', $data['due_date']),
            clients: $data['client_id']
        )];
    }
}
