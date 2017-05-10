<?php

use Illuminate\Database\Seeder;

class WarehousesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("warehouses")->insert([
            'description' => 'bodega 1',
            'address' => 'direccion 1',
        ]);
    }

}
