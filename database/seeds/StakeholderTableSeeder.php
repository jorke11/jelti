<?php

use Illuminate\Database\Seeder;

class StakeholderTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table("stakeholder")->insert([
            'type_regime_id' => 1,
            'type_person_id' => 1,
            'city_id' => 1,
            'type_document' => 1,
            'name' => 'Supplier 1',
            'address' => 'address',
            'last_name' => 'Supplier 1',
            'document' => '1233',
            'email' => 'supplier@',
            'responsible_id' => 1,
            'phone' => '23342',
            'contact' => 'contacto',
            'phone_contact' => '23234',
            'bussines_name' => 'bussines name',
            'term' => 45,
            'web_site' => "asdasd",
            'type_stakeholder' => 2,
            "status_id"=>1
        ]);
        DB::table("stakeholder")->insert([
            'type_regime_id' => 1,
            'type_person_id' => 1,
            'city_id' => 1,
            'type_document' => 2,
            'name' => 'client',
            'last_name' => 'client 1',
            'address' => 'address',
            'document' => '12332',
            'email' => 'supplier2@',
            'responsible_id' => 4,
            'phone' => '23342',
            'contact' => 'contacto',
            'phone_contact' => '23234',
            'bussines_name' => 'bussines name',
            'term' => 45,
            'web_site' => "asdasd",
            'type_stakeholder' => 1,
            "status_id"=>1
        ]);
        DB::table("stakeholder")->insert([
            'type_regime_id' => 1,
            'type_person_id' => 1,
            'city_id' => 1,
            'type_document' => 2,
            'name' => 'client 2',
            'last_name' => 'client 2',
            'address' => 'address',
            'document' => '12332',
            'email' => 'supplier2@',
            'responsible_id' => 3,
            'phone' => '23342',
            'contact' => 'contacto',
            'phone_contact' => '23234',
            'bussines_name' => 'bussines name',
            'term' => 45,
            'web_site' => "asdasd",
            'type_stakeholder' => 1,
            "status_id"=>1
        ]);
        DB::table("stakeholder")->insert([
            'type_regime_id' => 1,
            'type_person_id' => 1,
            'city_id' => 1,
            'type_document' => 2,
            'name' => 'Supplier 2',
            'address' => 'address',
            'last_name' => 'Supplier 2',
            'document' => '12332',
            'email' => 'supplier2@',
            'responsible_id' => 2,
            'phone' => '23342',
            'contact' => 'contacto',
            'phone_contact' => '23234',
            'bussines_name' => 'bussines name',
            'term' => 45,
            'web_site' => "asdasd",
            'type_stakeholder' => 2,
            "status_id"=>1
        ]);
    }

}
