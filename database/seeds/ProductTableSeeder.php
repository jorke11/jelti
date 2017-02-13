<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("product")->insert([
            'category_id' => 1,
            'supplier_id' => 1,
            'title' => 'product test',
            'description' => 'product test desc',
            'short_description' => 'sest',
            'reference' => 232423,
            'units_supplier' => 232423,
            'units_sf' => 232423,
            'cost_sf' => 232423,
            'tax' => 232423,
            'price_sf' => 232423,
            'price_cust' => 232423,
            'url_part' => "232423",
            'bar_code' => "232423",
            'status' => true,
            'minimun_stock' => 10,
        ]);
    }

}
