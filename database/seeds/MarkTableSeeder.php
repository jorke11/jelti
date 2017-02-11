<?php

use Illuminate\Database\Seeder;

class MarkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("mark")->insert([
            'description'=>'new mark'
        ]);
    }
}
