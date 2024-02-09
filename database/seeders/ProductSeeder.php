<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            ['name' => 'Poszwa', 'nick'=> null],
            ['name' => 'Poszewka', 'nick'=> null],
            ['name' => 'Prześcieradło', 'nick'=> null],
            ['name' => 'Obrus', 'nick'=> null],
            ['name' => 'Serwetka Duża ', 'nick'=> 'Ser. duża'],
            ['name' => 'Serwetka Mała', 'nick'=> 'Ser. mała'],
            ['name' => 'Ręcznik Duży', 'nick'=> null],
            ['name' => 'Ręcznik Mały', 'nick'=> null],
            ['name' => 'Stopka', 'nick'=> null],
            ['name' => 'Szlafrok', 'nick'=> null],
        ];

        foreach ($names as $name) {
            Product::create([
                'name' => $name['name'],
                'nickname' => $name['nick']
            ]);
        }
    }
}
