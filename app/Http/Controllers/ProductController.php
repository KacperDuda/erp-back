<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'nickname' => 'nullable|string'
        ]);

        return ['product' => Product::create($data)];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ['product' => Product::findOrFail($id)];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'nickname' => 'nullable|string'
        ]);

        $product = Product::findOrFail($id);

        $product->fill($data);
        $product->save();

        return ['product' => $product];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
        return ['message'=>'OK'];
    }
}
