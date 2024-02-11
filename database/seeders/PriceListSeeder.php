<?php

namespace Database\Seeders;

use App\Models\PriceList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list = [
            [
                'name' => "Główny",
                'parent_id' => null,
                'multiplier' => 1.0,
            ],
            [
                'name' => "Zniżka",
                'parent_id' => 1,
                'multiplier' => 1.1,
            ],
            [
                'name' => "Mega Bonus",
                'parent_id' => 2,
                'multiplier' => 1.1,
            ]
        ];

        foreach ($list as $elem) {
            PriceList::create($elem);
        }

    }
}
