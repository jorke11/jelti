<?php

use Illuminate\Database\Seeder;

class TyperegimesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("typeregimes")->insert([
            'description' => 'simpli',
        ]);
    }

}
