<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            ['name' => 'Hotel Górski', 'email' => 'kontakt@hotelgorski.pl', 'nickname' => 'Górski', 'address_line_1' => 'ul. Główna 1', 'address_line_2' => '34-400 Nowy Targ', 'NIP' => 1234567890, 'is_company' => true],
            ['name' => 'Noclegi Podhale', 'email' => 'info@noclegipodhale.pl', 'nickname' => 'Podhale', 'address_line_1' => 'ul. Pocztowa 2', 'address_line_2' => '34-400 Nowy Targ', 'NIP' => 2345678901, 'is_company' => true],
            ['name' => 'Hotel Tatry', 'email' => 'rezerwacja@hoteltatry.pl', 'nickname' => 'Tatry', 'address_line_1' => 'ul. Kasprowicza 3', 'address_line_2' => '34-400 Nowy Targ', 'NIP' => 3456789012, 'is_company' => true],
            ['name' => 'Pensjonat Giewont', 'email' => 'pensjonat@giewont.pl', 'nickname' => 'Giewontowy', 'address_line_1' => 'ul. Zakopiańska 4', 'address_line_2' => '34-400 Nowy Targ', 'NIP' => 4567890123, 'is_company' => true],
            ['name' => 'Hotel Rysy', 'email' => 'zapytania@hotelrysy.pl', 'nickname' => 'Rysy', 'address_line_1' => 'ul. Tatry 5', 'address_line_2' => '34-400 Nowy Targ', 'NIP' => 5678901234, 'is_company' => true],
            ['name' => 'Noclegi Tatra', 'email' => 'rezerwacje@noclegitatra.pl', 'nickname' => 'Tatra', 'address_line_1' => 'ul. Kasprowicza 6', 'address_line_2' => '34-400 Nowy Targ', 'NIP' => 6789012345, 'is_company' => true],
            ['name' => 'Hotel Giewont', 'email' => 'kontakt@hotelgiewont.pl', 'nickname' => 'Giewont', 'address_line_1' => 'ul. Tatry 7', 'address_line_2' => '34-400 Nowy Targ', 'NIP' => 7890123456, 'is_company' => true],
            ['name' => 'Pensjonat Podhale', 'email' => 'info@pensjonatpodhale.pl', 'nickname' => 'Podhalański', 'address_line_1' => 'ul. Zakopiańska 8', 'address_line_2' => '34-400 Nowy Targ', 'NIP' => 8901234567, 'is_company' => true],
            ['name' => 'Hotel Nowy Targ', 'email' => 'rezerwacje@hotelnowytarg.pl', 'nickname' => 'Nowy Targ', 'address_line_1' => 'ul. Główna 9', 'address_line_2' => '34-400 Nowy Targ', 'NIP' => 9012345678, 'is_company' => true],
            ['name' => 'Noclegi Góralskie', 'email' => 'kontakt@noclegigóralskie.pl', 'nickname' => 'Góralskie', 'address_line_1' => 'ul. Pocztowa 10', 'address_line_2' => '34-400 Nowy Targ', 'NIP' => 1023456789, 'is_company' => true]
        ];

        foreach ($clients as $client) {
            $client['price_list_id'] = rand(1,3);

            Client::create($client);
        }
     }
}
