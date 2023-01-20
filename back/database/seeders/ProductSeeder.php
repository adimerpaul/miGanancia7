<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name'=>"Aceite comestibles",
                'avatar'=>"aceite.jpg",
                'barra'=>"",
                'unitSelect'=>"no",
                'unit'=>"",
                'stock'=>"100",
                'costUnit'=>0,
                'unitSale'=>0,
                'priceUnit'=>30,
                'visible'=>"yes",
                'description'=>"",
                'shop_id'=>"1",
                'category_id'=>"1",
            ],
            [
                'name'=>"Avena",
                'avatar'=>"avena.jpg",
                'barra'=>"",
                'unitSelect'=>"no",
                'unit'=>"",
                'stock'=>"100",
                'costUnit'=>0,
                'unitSale'=>0,
                'priceUnit'=>15,
                'visible'=>"yes",
                'description'=>"",
                'shop_id'=>"1",
                'category_id'=>"1",
            ],
            [
                'name'=>"Aceitunas",
                'avatar'=>"aceitunas.jpg",
                'barra'=>"",
                'unitSelect'=>"no",
                'unit'=>"",
                'stock'=>"100",
                'costUnit'=>0,
                'unitSale'=>0,
                'priceUnit'=>15,
                'visible'=>"yes",
                'description'=>"",
                'shop_id'=>"1",
                'category_id'=>"2",
            ]
        ]);
    }
}
