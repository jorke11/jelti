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
        $this->call(CategoriesTableSeeder::class);
        $this->call(WarehousesTableSeeder::class);
//        $this->call(SuppliersTableSeeder::class);
        $this->call(StakeholderTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(MarkTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionsuserTableSeeder::class);
        $this->call(CharacteristicTableSeeder::class);
        $this->call(BranchTableSeeder::class);
//        $this->call(EntriesTableSeeder::class);
//        $this->call(EntriesDetailTableSeeder::class);
        $this->call(PucTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(ParameterTableSeeder::class);
        $this->call(ConsecutiveTableSeeder::class);
        
    }

}
