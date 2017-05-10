<?php

use Illuminate\Database\Seeder;

class CharacteristicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("products_characteristic")->insert([
            'description' => 'characteristic'
        ]);
        DB::table("products_characteristic")->insert([
            'description' => 'characteristic 2'
        ]);
    }
}
