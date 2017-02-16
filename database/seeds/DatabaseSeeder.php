<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call(UsersTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(TypepersonTableSeeder::class);
        $this->call(TyperegimeTableSeeder::class);
        $this->call(WarehouseTableSeeder::class);
        $this->call(SupplierTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(MarkTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(ProfileTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
    }

}
