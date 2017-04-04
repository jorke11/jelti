<?php

use Illuminate\Database\Seeder;

class ConsecutiveTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("consecutives")->insert([
            'description' => 'consecutive invoice',
            'type_form' => 1,
            'initial' => 1,
            'final' => 100,
            "large" => 6
        ]);

        DB::table("consecutives")->insert([
            'description' => 'consecutive Entry',
            'type_form' => 2,
            'initial' => 1,
            'final' => 100,
            "pronoun" => "ent",
            "large" => 6
        ]);
        DB::table("consecutives")->insert([
            'description' => 'consecutive departure',
            'type_form' => 3,
            'initial' => 1,
            'final' => 100,
            "pronoun" => "dep",
            "large" => 6
        ]);
        DB::table("consecutives")->insert([
            'description' => 'consecutive purchase',
            'type_form' => 4,
            'initial' => 1,
            'final' => 100,
            "pronoun" => "purc",
            "large" => 6
        ]);
    }

}
