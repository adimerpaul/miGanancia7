<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shop::create([
            'avatar' => 'images/logo.png',
            'type' => 'Loja',
            'name' => 'Loja 1',
            'address' => 'Rua 1',
            'city' => 'Cidade 1',
            'phone' => '123456789',
            'email' => 'loja@gmail.com',
            'document' => '123456789'
        ]);
    }
}
