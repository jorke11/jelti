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
            'name' => 'Sebastian',
            'address' => 'Cra 4 # 64 - 38',
            'last_name' => 'Dugand',
            'document' => '1032659865',
            'email' => 'sebantian@superfuds.com.co',
            'responsible_id' => 1,
            'phone' => '300356985',
            'contact' => 'Carolina Rodriguez',
            'phone_contact' => '32136545845',
            'business_name' => 'Superfuds s.a.s',
            'business' => 'superfuds',
            'term' => 45,
            'web_site' => "www.superfuds.com",
            'type_stakeholder' => 2,
            "status_id" => 1
        ]);
    }

}
