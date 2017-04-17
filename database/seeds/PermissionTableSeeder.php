<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        /**
         * Modules
         */
        DB::table("permissions")->insert([
            'typemenu_id' => 0,
            'parent_id' => 0,
            'description' => 'Module Home',
            'icon' => 'fa-home',
            'controller' => '',
            'priority' => 1,
            'title' => 'Home',
        ]);
        DB::table("permissions")->insert([
            'typemenu_id' => 0,
            'parent_id' => 0,
            'description' => 'Module security',
            'icon' => 'fa-unlock-alt',
            'controller' => '',
            'priority' => 2,
            'title' => 'security',
        ]);


        DB::table("permissions")->insert([
            'typemenu_id' => 0,
            'parent_id' => 0,
            'description' => 'Module Suller',
            'icon' => 'fa-home',
            'controller' => '',
            'priority' => 3,
            'title' => 'Sellers',
        ]);

        DB::table("permissions")->insert([
            'typemenu_id' => 0,
            'parent_id' => 0,
            'description' => 'Module Administration',
            'icon' => 'chevron-down',
            'controller' => '',
            'priority' => 4,
            'title' => 'Administration',
        ]);

        DB::table("permissions")->insert([
            'typemenu_id' => 0,
            'parent_id' => 0,
            'description' => 'Module Invoicing',
            'icon' => 'chevron-down',
            'controller' => '',
            'priority' => 5,
            'title' => 'Invoicing',
        ]);
        DB::table("permissions")->insert([
            'typemenu_id' => 0,
            'parent_id' => 0,
            'description' => 'Module Inventory',
            'icon' => 'chevron-down',
            'controller' => '',
            'priority' => 6,
            'title' => 'Inventory',
        ]);

        /**
         * Submodule
         */
        /**
         * SHOP 
         */
        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 1,
            'description' => 'form Shop',
            'controller' => '/shopping',
            'priority' => 2,
            'title' => 'Shop',
        ]);


        /**
         * SECURITY
         */
        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 2,
            'description' => 'form Users',
            'controller' => '/user',
            'priority' => 1,
            'title' => 'Users',
        ]);
        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 2,
            'description' => 'form ROle',
            'controller' => '/role',
            'priority' => 2,
            'title' => 'Role',
        ]);

        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 2,
            'description' => 'form Permission',
            'controller' => '/permission',
            'priority' => 2,
            'title' => 'Permission',
        ]);

        /**
         * Sellers
         */
        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 3,
            'description' => 'form Activities',
            'controller' => '/activity',
            'priority' => 1,
            'title' => 'activity',
        ]);

        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 3,
            'description' => 'form Posibles cliente',
            'controller' => '/prospect',
            'priority' => 2,
            'title' => 'Posibles clientes',
        ]);

        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 3,
            'description' => 'form Cumplimiento',
            'controller' => '/fulfillment',
            'priority' => 3,
            'title' => 'Cumplimiento',
        ]);
        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 3,
            'description' => 'form Tickets',
            'controller' => '/ticket',
            'priority' => 4,
            'title' => 'Ticket',
        ]);

        //Administration
        /**
         * Products
         */
        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 4,
            'description' => 'Option product',
            'controller' => '',
            'priority' => 1,
            'icon' => 'fa-home',
            'title' => 'Products',
        ]);
        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 15,
            'description' => 'form product',
            'controller' => '',
            'priority' => 1,
            'icon' => 'fa-home',
            'title' => 'Product',
        ]);

        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 15,
            'description' => 'form category',
            'controller' => '',
            'priority' => 1,
            'icon' => 'fa-home',
            'title' => 'Category',
        ]);
        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 15,
            'description' => 'form characteristic',
            'controller' => '',
            'priority' => 1,
            'icon' => 'fa-home',
            'title' => 'Characteristic',
        ]);

        /**
         * Invoicing
         */
        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 5,
            'description' => 'form purchase',
            'controller' => '/purchase',
            'priority' => 1,
            'icon' => '',
            'title' => 'Purchase',
        ]);
        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 5,
            'description' => 'form sale',
            'controller' => '/sale',
            'priority' => 1,
            'icon' => '',
            'title' => 'Sale',
        ]);


        /**
         * Inventory
         */
        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 6,
            'description' => 'form Entry',
            'controller' => '/entry',
            'priority' => 1,
            'icon' => '',
            'title' => 'Entry',
        ]);
        DB::table("permissions")->insert([
            'typemenu_id' => 1,
            'parent_id' => 6,
            'description' => 'form Departure',
            'controller' => '/departure',
            'priority' => 1,
            'icon' => '',
            'title' => 'Departure',
        ]);
    }

}
