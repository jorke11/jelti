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
            'name'=>'jorge',
            'email'=>'jpinedom@hotmail.com',
            'role_id'=>1,
            'warehouse_id'=>1,
            'stakeholder_id'=>1,
            'city_id'=>1,
            'status'=>true,
            'password'=>bcrypt('123456')
        ]);
    }

}
