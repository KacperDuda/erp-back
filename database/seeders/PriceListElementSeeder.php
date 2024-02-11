<?php

namespace Database\Seeders;

use App\Models\PriceList;
use App\Models\PriceListElement;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Nette\Utils\Random;

class PriceListElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $priceLists = PriceList::where("parent_id", null)->get();

        foreach ($priceLists as $pirceList) {
            foreach ($products as $product) {
                PriceListElement::create([
                    'product_id' => $product->id,
                    'price_list_id' => $pirceList->id,
                    'price' => mt_rand(120, 540),
                    'VAT'=>0.23
                ]);
            }
        }
    }
}
