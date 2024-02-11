<?php

namespace App\Http\Controllers;

use App\Models\PriceList;
use Illuminate\Http\Request;

class PriceListController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PriceList::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): array
    {
        return ['price_lists' => PriceList::all()];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): array
    {
        $data = $request->validate([
            'name'=>'required|string',
            'parent_id'=>'nullable|integer',
            'multiplier'=>'required|decimal:0,3'
        ]);

        $priceList = PriceList::create($data);
        return ['price_list'=>$priceList];
    }

    /**
     * Display the specified resource.
     */
    public function show($id): array
    {
        return ['price_list' => PriceList::findOrFail($id)];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'parent_id'=>'nullable|integer',
            'multiplier'=>'required|decimal:0,3'
        ]);

        $priceList = PriceList::findOrFail($id);
        $priceList->fill($data);
        $priceList->save();

        return ['price_list'=>$priceList];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        PriceList::destroy($id);
        return ['message'=>'OK'];
    }
}
