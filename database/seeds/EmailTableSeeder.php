<?php

use Illuminate\Database\Seeder;

class EmailTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("email")->insert([
            'description' => 'purchases',
        ]);
    }

}
