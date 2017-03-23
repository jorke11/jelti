<?php

use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("contacts")->insert([
            'stakeholder_id' => 1,
            'commercial_id' => 1,
            'source_id' => 1,
            'city_id' => 1,
            'name' => 'Contact 1',
            'last_name' => 'contact 1',
            'position' => 'seo',
            'address' => 'address',
            'email' => 'contact@',
            'phone' => '23342',
            'mobile' => '23342',
            'web_site' => "asdasd",
        ]);
    }

}
