<?php

namespace App\Http\Controllers;

use App\Models\PriceListElement;
use Illuminate\Http\Request;

class PriceListElementController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PriceListElement::class);
    }

    protected array $rules = [
        'price_list_id'=>'required|integer',
        'product_id'=>'required|integer',
        'price'=>'required|integer',
        'vat'=>'required|decimal:0,3'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ['price_list_elements'=>PriceListElement::all()];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): array
    {
        $data = $request->validate($this->rules);
        return ['price_list_element'=>PriceListElement::create($data)];
    }

    /**
     * Display the specified resource.
     */
    public function show($id): array
    {
        return ['price_list_element'=>PriceListElement::findOrFail($id)];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules);

        $price_list_element = PriceListElement::findOrFail($id);
        $price_list_element->fill($data);
        $price_list_element->save();

        return ['price_list_element'=>$price_list_element];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        PriceListElement::destroy($id);
        return ['message'=>'ok'];
    }
}
