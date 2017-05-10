<?php

use Illuminate\Database\Seeder;

class EntriesDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("entries_detail")->insert([
            'entry_id' => 1,
            'product_id' => 1,
            'quantity' => 50,
            'expiration_date' => date("Y-m-d H:i"),
            'value' => 25500,
            'lot' => '2100',
            
        ]);
    }
}
