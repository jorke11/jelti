<?php

use Illuminate\Database\Seeder;

class WarehouseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("warehouse")->insert([
            'description'=>'bogota',
            'address'=>'cra 4 # 69-23'
        ]);
    }
}
