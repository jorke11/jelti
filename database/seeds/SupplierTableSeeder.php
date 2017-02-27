<?php

use Illuminate\Database\Seeder;

class SupplierTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("supplier")->insert([
            'type_regime_id' => 1,
            'type_person_id' => 1,
            'city_id' => 1,
            'name' => 'Supplier 1',
            'address' => 'address',
            'last_name' => 'Supplier 1',
            'document' => '1233',
            'email' => 'supplier@',
            'commercial_id' => 1,
            'phone' => '23342',
            'contact' => 'contacto',
            'phone_contact' => '23234',
            'bussines_name'=>'bussines name',
            'term' => 45,
            'web_site' => "asdasd",
        ]);
    }

}
