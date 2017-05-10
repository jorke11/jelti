<?php

use Illuminate\Database\Seeder;

class BranchTableSeeder extends Seeder
{
    
    public function run()
    {
         DB::table("branch_office")->insert([
            'client_id' => 1,
            'city_id' => 1,
            'address' => 'bogota creera',
            'name' => 'name branch',
            'phone' => '23434',
             
        ]);
    }
}
