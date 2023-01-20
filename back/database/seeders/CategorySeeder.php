<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("categories")->insert([
            [
                'name' => 'ABARROTES',
                'visible' => 'yes',
                'shop_id' => 1,
            ],
            [
                'name' => 'ENLATADOS',
                'visible' => 'yes',
                'shop_id' => 1,
            ],
            [
                'name' => 'LÁCTEOS',
                'visible' => 'yes',
                'shop_id' => 1,
            ],
            [
                'name' => 'CONFITERÍA',
                'visible' => 'yes',
                'shop_id' => 1,
            ]
        ]);
    }
}
