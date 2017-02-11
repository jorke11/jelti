<?php

use Illuminate\Database\Seeder;

class WarehouseTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("warehouse")->insert([
            'description' => 'bodega 1',
            'address' => 'direccion 1',
        ]);
    }

}
