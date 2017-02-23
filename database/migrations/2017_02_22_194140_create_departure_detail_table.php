<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartureDetailTable extends Migration
{
   
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('departure_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('departure_id');
            $table->integer('product_id');
            $table->integer('category_id');
            $table->integer('quantity');
            $table->decimal('value', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('departure_detail');
    }
}
