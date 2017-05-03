<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("users")->insert([
            'name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@superfuds.com.co',
            'role_id' => 1,
            'stakeholder_id' => 1,
            'city_id' => 1,
            'status_id' => 1,
            'document' => 1,
            'password' => bcrypt('admin')
        ]);
        DB::table("users")->insert([
            'name' => 'jorge',
            'last_name' => 'pinedo',
            'email' => 'tech@superfuds.com.co',
            'role_id' => 1,
            'stakeholder_id' => 1,
            'city_id' => 1,
            'status_id' => 1,
            'document' => 1,
            'password' => bcrypt('123')
        ]);
    }

}
