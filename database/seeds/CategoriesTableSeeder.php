<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("categories")->insert([
            'description' => 'Snacks',
            'short_description' => 'Snacks',
            'order' => 1,
            'image'=>'images/categories/01.png'
        ]);
        DB::table("categories")->insert([
            'description' => 'Bebidas',
            'short_description' => 'Bebidas',
            'order' => 2,
            'image'=>'images/categories/02.png'
        ]);
        DB::table("categories")->insert([
            'description' => 'Semillas',
            'short_description' => 'Semillas',
            'order' => 3,
            'image'=>'images/categories/03.png'
        ]);
        DB::table("categories")->insert([
            'description' => 'Cereales y Pseudo Cereales',
            'short_description' => 'Cereales y Pseudo Cereales',
            'order' => 4,
            'image'=>'images/categories/04.png'
        ]);
        DB::table("categories")->insert([
            'description' => 'Harinas Saludables',
            'short_description' => 'Harinas Saludables',
            'order' => 5,
            'image'=>'images/categories/05.png'
        ]);
        DB::table("categories")->insert([
            'description' => 'SuperAlimentos',
            'short_description' => 'SuperAlimentos',
            'order' => 6,
            'image'=>'images/categories/06.png'
        ]);
        DB::table("categories")->insert([
            'description' => 'Granel',
            'short_description' => 'Granel',
            'order' => 7,
            'image'=>'images/categories/07.png'
        ]);
        DB::table("categories")->insert([
            'description' => 'Endulzantes',
            'short_description' => 'Endulzantes',
            'order' => 8,
            'image'=>'images/categories/08.png'
        ]);
        DB::table("categories")->insert([
            'description' => 'Aceites',
            'short_description' => 'Aceites',
            'order' => 9,
            'image'=>'images/categories/09.png'
        ]);
        DB::table("categories")->insert([
            'description' => 'Especies',
            'short_description' => 'Especies',
            'order' => 10,
            'image'=>'images/categories/10.png'
        ]);
        DB::table("categories")->insert([
            'description' => 'Linea Fit',
            'short_description' => 'Linea Fit',
            'order' => 11,
            'image'=>'images/categories/11.png'
        ]);
        DB::table("categories")->insert([
            'description' => 'Chocolateria',
            'short_description' => 'Chocolateria',
            'order' => 12,
            'image'=>'images/categories/12.png'
        ]);
    }

}
