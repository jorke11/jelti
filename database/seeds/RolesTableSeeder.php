<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("roles")->insert([
            'description' => 'Administrator'
        ]);
        DB::table("roles")->insert([
            'description' => 'Client'
        ]);
        DB::table("roles")->insert([
            'description' => 'Supplier'
        ]);
        DB::table("roles")->insert([
            'description' => 'Commercial'
        ]);
        DB::table("roles")->insert([
            'description' => 'warehouse'
        ]);
    }

}
