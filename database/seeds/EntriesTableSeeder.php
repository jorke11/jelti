<?php

use Illuminate\Database\Seeder;

class EntriesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("entries")->insert([
            'warehouse_id' => 1,
            'responsible_id' => 1,
            'city_id' => 1,
            'status_id' => 1,
            'supplier_id' => 1,
            'description' => "entries seeder",
            'invoice' => "entries invoice",
            'created' => date("Y-m-d H:i"),
            "consecutive" => "ent001"
        ]);
    }

}
