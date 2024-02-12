<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Entry;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();
        $products = Product::all();
//        $days = [10,9,8,7,6,5,4,3,2,1,0];
        $days = [0];
//          $days = [];


        foreach ($days as $day) {
            foreach ($products as $product) {
                foreach ($clients as $client) {
                    for ($i = 0; $i < max(rand(0, 100)-90, 0); $i++) { // random amount of entries, i want more to be empty
                        $entry = new Entry;
                        $entry->fill([
                            'amount'=>rand(1,4),
                            'comment'=>null,
                            'product_id'=>$product->id,
                            'client_id'=>$client->id,
                            'color'=>'grey',
                            'user_id'=>1,
                            'unit_price'=>$client->priceOf($product),
                            'vat'=>$client->vatOf($product),
                            'left'=>false,
                            'posting_date'=>now()->subDays($day)
                        ]);
                        $entry->created_at = now()->subDays($day);
                        $entry->updated_at = $entry->created_at;

                        $entry->save();
                    }
                }
            }
        }
    }
}
