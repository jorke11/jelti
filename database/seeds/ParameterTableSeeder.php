<?php

use Illuminate\Database\Seeder;

class ParameterTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("parameters")->insert([
            'description' => "new",
            'group' => "entry",
            'code' => 1,
            
        ]);
        
        DB::table("parameters")->insert([
            'description' => "Pending",
            'group' => "entry",
            'code' => 2,
        ]);
        
        DB::table("parameters")->insert([
            'description' => "checked",
            'group' => "entry",
            'code' => 3,
        ]);
        
        DB::table("parameters")->insert([
            'description' => "canceled",
            'group' => "entry",
            'code' => 4,
        ]);
        DB::table("parameters")->insert([
            'description' => "retefuente",
            'group' => "tax",
            "value"=>"0.025",
            'code' => 1,
        ]);
        DB::table("parameters")->insert([
            'description' => "base retefuente",
            'group' => "tax",
            "value"=>"860000",
            'code' => 2,
        ]);
    }

}
