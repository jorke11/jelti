<?php

use Illuminate\Database\Seeder;

class TyperegimeTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("typeregime")->insert([
            'description' => 'simpli',
        ]);
    }

}
