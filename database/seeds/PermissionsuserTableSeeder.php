<?php

use Illuminate\Database\Seeder;

class PermissionsuserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table("permissions_user")->insert([
            'users_id' => 1,
            'permission_id' => 1
        ]);
         DB::table("permissions_user")->insert([
            'users_id' => 1,
            'permission_id' => 2
        ]);
         DB::table("permissions_user")->insert([
            'users_id' => 1,
            'permission_id' => 3
        ]);
    }
}
