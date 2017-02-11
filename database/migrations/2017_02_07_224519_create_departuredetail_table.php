<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeparturedetailTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('departuredetail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('products_id');
            $table->integer('quantity');
            $table->dateTime('created');
            $table->decimal('value', 15, 2);
            $table->integer('category_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('departuredetail');
    }

}
