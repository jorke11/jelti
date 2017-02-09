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
            $table->string('title', 120);
            $table->string('description', 100);
            $table->string('short_description', 100);
            $table->string('reference', 10);
            $table->decimal('units_supplier', 15, 2);
            $table->decimal('units_sf', 15, 2);
            $table->decimal('cost_sf', 15, 2);
            $table->decimal('tax', 15, 2);
            $table->decimal('price_sf', 15, 2);
            $table->decimal('price_cust', 15, 2);
            $table->integer('categories_id');
            $table->integer('supplier_id');
            $table->string('url_part', 60);
            $table->string('bar_code', 30);
            $table->string('image', 20)->nullable();
            $table->string('other_images', 100)->nullable();
            $table->integer('status_id');
            $table->string('meta_title', 100)->nullable();
            $table->string('meta_keywords', 100)->nullable();
            $table->string('meta_description', 100)->nullable();
            $table->integer('minimun_stock');
            $table->timestamps();
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
