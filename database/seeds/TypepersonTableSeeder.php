<?php

use Illuminate\Database\Seeder;

class TypepersonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("typeperson")->insert([
            'description'=>'natural',
        ]);
    }
}
