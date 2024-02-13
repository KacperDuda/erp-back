<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\Invoices\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Generator::invoices(
            now()->year,
            now()->month,
            User::findOrFail(1)->name,
            now()->startOfMonth(), // 00:00:00
            now()->endOfMonth(), // 23:59:59
            now(),
            now()->addDays(14)
        );
    }
}
