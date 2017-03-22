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
            'email' => 'admin@admin.com',
            'role_id' => 1,
            'warehouse_id' => 1,
            'stakeholder_id' => 1,
            'city_id' => 1,
            'status' => true,
            'password' => bcrypt('admin')
        ]);
        DB::table("users")->insert([
            'name' => 'jorge',
            'last_name' => 'pinedo',
            'email' => 'jpinedom@hotmail.com',
            'role_id' => 1,
            'warehouse_id' => 1,
            'stakeholder_id' => 1,
            'city_id' => 1,
            'status' => true,
            'password' => bcrypt('123456')
        ]);
        DB::table("users")->insert([
            'name' => 'commercial 1',
            'last_name' => 'commercial 1',
            'email' => 'comercial1@hotmail.com',
            'role_id' => 4,
            'warehouse_id' => 1,
            'stakeholder_id' => 1,
            'city_id' => 1,
            'status' => true,
            'password' => bcrypt('123456')
        ]);
        DB::table("users")->insert([
            'name' => 'commercial 2',
            'last_name' => 'commercial 2',
            'email' => 'comercial2@hotmail.com',
            'role_id' => 4,
            'warehouse_id' => 1,
            'stakeholder_id' => 1,
            'city_id' => 1,
            'status' => true,
            'password' => bcrypt('123456')
        ]);
    }

}
