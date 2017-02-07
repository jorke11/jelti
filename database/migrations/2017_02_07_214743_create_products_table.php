<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url_part', 60);
            $table->string('bar_code', 30);
            $table->string('reference', 10);
            $table->string('title', 120);
            $table->boolean('status');
            $table->decimal('units_supplier',15,2);
            $table->numeric('units_sf',15,2);
            $table->numeric('cost_sf',15,2);
            $table->numeric('tax',15,2);
            $table->numeric('price_sf',15,2);
            $table->numeric('price_cust',15,2);
            $table->string('image', 20);
            $table->string('other_images', 100);
            $table->string('description', 100);
            $table->string('short_description', 100);
            $table->string('meta_title', 100);
            $table->string('meta_keywords', 100);
            $table->string('meta_description', 100);
            $table->integer('categories_id');
            $table->integer('supplier_id');
            $table->integer('minimun_stock');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
       Schema::drop('products');
    }

}
