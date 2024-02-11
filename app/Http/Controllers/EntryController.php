<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Entry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EntryController extends Controller
{
    protected $rules = [
        'amount'=>'required|integer',
        'comment'=>'string|nullable',
        'product_id'=>'integer',
        'color'=>'string|nullable',
        'user_id'=>'required|integer',
        'unit_price'=>'nullable|integer',
        'vat'=>'nullable|numeric',
        'left'=>'required|boolean',
        'posting_date'=>'required|date_format:Y-m-d',
        'client_id' => 'required|integer'
    ];

    public function __construct()
    {
        // i will authorize manually
        // $this->authorizeResource(Entry::class);
    }

    public function index() {
        throw new \Exception('Use POST method on /entries/list');
    }

    /**
     * Display a listing of the resource.
     */
    public function list(Request $request): array
    {
        $dates = $request->validate([
            'start_date' => 'date_format:Y-m-d',
            'end_date' => 'date_format:Y-m-d',
        ]);

        $start = Carbon::createFromFormat('Y-m-d', $dates['start_date'])->setHour(0)->setMinute(0)->setSecond(0);
        $stop = Carbon::createFromFormat('Y-m-d', $dates['end_date'])->setHour(23)->setMinute(59)->setSecond(59);

        $entries = Entry::whereBetween('posting_date', [$start, $stop])->get();

        Gate::authorize('view', $entries->first());

        return ['entries'=>$entries];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): array
    {
        $data = $request->validate($this->rules);

        $entry = new Entry;

        return $this->modifyAndSave($data, $entry);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $entry = Entry::findOrFail($id);
        Gate::authorize('entry:view', $entry);
        return ['entry'=>$entry];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): array
    {
        $data = $request->validate($this->rules);

        $entry = Entry::findOrFail($id);

        return $this->modifyAndSave($data, $entry);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $entry = Entry::findOrFail($id);
        Gate::authorize('entry:modify', $entry);
        $entry->delete();
        return ['message'=>'ok'];
    }

    /**
     * @param array $data
     * @param $entry
     * @return array
     */
    public function modifyAndSave(array $data, $entry): array
    {
        $client = Client::findOrFail($data['client_id']);

        if(is_null($data['unit_price'])) {
            if(is_null($entry->unit_price)) {
                $data['unit_price'] = $client->priceOf($data['product_id']);
            }
            else {
                unset($data['unit_price']);
            }
        }

        if(is_null($data['vat'])) {
            if(is_null($entry->vat)) {
                $data['vat'] = $client->vatOf($data['product_id']);
            }
            else {
                unset($data['vat']);
            }
        }



        $entry->fill($data);

        Gate::authorize('entry:modify', $entry);

        $entry->save();
        return ['entry' => $entry];
    }
}
