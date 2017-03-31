<?php

use Illuminate\Database\Seeder;

class ParameterTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("parameters")->insert([
            'description' => "new",
            'group' => "entry",
            'code' => 1,
        ]);

        DB::table("parameters")->insert([
            'description' => "Pending",
            'group' => "entry",
            'code' => 2,
        ]);

        DB::table("parameters")->insert([
            'description' => "checked",
            'group' => "entry",
            'code' => 3,
        ]);

        DB::table("parameters")->insert([
            'description' => "canceled",
            'group' => "entry",
            'code' => 4,
        ]);


        DB::table("parameters")->insert([
            'description' => "retefuente",
            'group' => "tax",
            "value" => "0.025",
            'code' => 1,
        ]);
        DB::table("parameters")->insert([
            'description' => "base retefuente",
            'group' => "tax",
            "value" => "860000",
            'code' => 2,
        ]);
        DB::table("parameters")->insert([
            'description' => "email",
            'group' => "notification",
            'code' => 1,
        ]);
        DB::table("parameters")->insert([
            'description' => "sms",
            'group' => "notification",
            'code' => 2,
        ]);
        DB::table("parameters")->insert([
            'description' => "plataform",
            'group' => "notification",
            'code' => 3,
        ]);
        DB::table("parameters")->insert([
            'description' => "natural",
            'group' => "typeperson",
            'code' => 1,
        ]);
        DB::table("parameters")->insert([
            'description' => "juridica",
            'group' => "typeperson",
            'code' => 2,
        ]);
        DB::table("parameters")->insert([
            'description' => "comun",
            'group' => "typeregimen",
            'code' => 1,
        ]);
        DB::table("parameters")->insert([
            'description' => "simplificado",
            'group' => "typeregimen",
            'code' => 2,
        ]);
        DB::table("parameters")->insert([
            'description' => "nit",
            'group' => "typedocument",
            'code' => 1,
        ]);
        DB::table("parameters")->insert([
            'description' => "cedula",
            'group' => "typedocument",
            'code' => 2,
        ]);

        DB::table("parameters")->insert([
            'description' => "client",
            'group' => "typestakeholder",
            'code' => 1,
        ]);
        DB::table("parameters")->insert([
            'description' => "supplier",
            'group' => "typestakeholder",
            'code' => 2,
        ]);
        DB::table("parameters")->insert([
            'description' => "active",
            'group' => "generic",
            'code' => 1,
        ]);
        DB::table("parameters")->insert([
            'description' => "disactive",
            'group' => "generic",
            'code' => 2,
        ]);
        DB::table("parameters")->insert([
            'description' => "open",
            'group' => "ticket",
            'code' => 1,
        ]);
        DB::table("parameters")->insert([
            'description' => "closed",
            'group' => "ticket",
            'code' => 2,
        ]);
        
        DB::table("parameters")->insert([
            'description' => "technology",
            'group' => "department",
            'code' => 1,
        ]);
        DB::table("parameters")->insert([
            'description' => "commercial",
            'group' => "department",
            'code' => 2,
        ]);
        DB::table("parameters")->insert([
            'description' => "operation",
            'group' => "department",
            'code' => 3,
        ]);
        DB::table("parameters")->insert([
            'description' => "Alto",
            'group' => "priority",
            'code' => 1,
        ]);
        DB::table("parameters")->insert([
            'description' => "Medio",
            'group' => "priority",
            'code' => 2,
        ]);
        DB::table("parameters")->insert([
            'description' => "Bajo",
            'group' => "priority",
            'code' => 3,
        ]);
    }

}
