<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $rules = [
        'price_list_id'=>'required|integer',
        'name'=>'required|string',
        'email'=>'required|email',//email:
        'nickname'=>'string',
        'address_line_1'=>'string',
        'address_line_2'=>'string',
        'additional_info'=>'string',
        'NIP'=>'required|numeric',
        'is_company'=>'required|boolean',
        'comment'=>'string'
    ];

    public function __construct()
    {
        $this->authorizeResource(Client::class);
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
    public function show(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
