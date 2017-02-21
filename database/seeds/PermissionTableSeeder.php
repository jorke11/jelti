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
            'icon' => 'fa-unlock-alt',
            'controller' => '',
            'priority' => 1,
            'title' => 'security',
        ]);
        
        DB::table("permission")->insert([
            'typemenu_id' => 1,
            'parent_id' => 1,
            'description' => 'form Users',
            'controller' => '/user',
            'priority' => 1,
            'title' => 'Users',
        ]);
        DB::table("permission")->insert([
            'typemenu_id' => 1,
            'parent_id' => 1,
            'description' => 'form Permission',
            'controller' => '/permission',
            'priority' => 2,
            'title' => 'Permission',
        ]);
    }
}
