<?php

use Illuminate\Database\Seeder;

class PucTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table("puc")->insert([
            'code' => '220501',
            'account' => "supplier",
            'nature' => 2
        ]);

        DB::table("puc")->insert([
            'code' => '130501',
            'account' => "clients",
            'nature' => 1
        ]);

        DB::table("puc")->insert([
            'code' => '413501',
            'account' => "Comercio x mayor y menor",
            'nature' => 1
        ]);

        DB::table("puc")->insert([
            'code' => '143501',
            'account' => "Inventory",
            'nature' => 2
        ]);
        DB::table("puc")->insert([
            'code' => '240802',
            'account' => "iva compra",
            'nature' => 1
        ]);
        DB::table("puc")->insert([
            'code' => '240801',
            'account' => "iva venta",
            'nature' => 2
        ]);
    }

}
