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
        'additional_info'=>'string|nullable',
        'NIP'=>'required|numeric',
        'is_company'=>'required|boolean',
        'comment'=>'string|nullable'
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
        return ['clients' => Client::all()];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules);
        return ['client'=>Client::create($data)];
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return ['client'=>Client::findOrFail($id)];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules);
        $client = Client::findOrFail($id);
        $client->fill($data);
        $client->save();
        return ['client'=>$client];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Client::destroy($id);
        return ['message'=>'ok'];
    }
}
