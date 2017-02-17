<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("permission")->insert([
            'typemenu_id' => 0,
            'parent_id' => 0,
            'description' => 'Module security',
            'controller' => '/user',
            'title' => 'security',
        ]);
    }
}
