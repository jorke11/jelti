<?php

use Illuminate\Database\Seeder;

class PermissionuserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table("permissionuser")->insert([
            'users_id' => 1,
            'permission_id' => 1
        ]);
         DB::table("permissionuser")->insert([
            'users_id' => 1,
            'permission_id' => 2
        ]);
         DB::table("permissionuser")->insert([
            'users_id' => 1,
            'permission_id' => 3
        ]);
    }
}
