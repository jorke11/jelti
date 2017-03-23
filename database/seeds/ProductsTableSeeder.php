<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        for ($i = 0; $i < 10; $i++) {
            DB::table("products")->insert([
                'category_id' => 1,
                'supplier_id' => rand(1, 2),
                'title' => 'product test ' . $i,
                'description' => 'product test desc ' . $i,
                'short_description' => 'sest',
                'reference' => 232423 + $i,
                'units_supplier' => 232423,
                'units_sf' => 232423,
                'cost_sf' => 232423,
                'tax' => 19,
                'price_sf' => 232423,
                'price_cust' => 232423,
                'url_part' => "232423",
                'bar_code' => "232423",
                'status' => true,
                'minimum_stock' => 10,
                "account_id" => 1,
                "packaging" => 5
            ]);
        }
    }

}
