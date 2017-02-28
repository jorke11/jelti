<?php

use Illuminate\Database\Seeder;

class TypepersonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("typepersons")->insert([
            'description'=>'natural',
        ]);
    }
}
