<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Admin',
            'email'=>'admin@admin.pl',
            'password'=>Hash::make('admin'),
            'is_admin'=>true,
            'abilities'=>[]
        ]);

        User::create([
            'name'=>'User',
            'email'=>'badmin@admin.pl',
            'password'=>Hash::make('admin'),
            'is_admin'=>false,
            'abilities'=>['entry:limited', 'product:viewAny', 'client:viewAny']
        ]);
    }
}
