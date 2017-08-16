<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsCharacteristTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products_characteristic', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('image')->nullable();
            $table->integer('order')->nullable();
            $table->integer('type_subcategory_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products_characteristic');
    }

}
