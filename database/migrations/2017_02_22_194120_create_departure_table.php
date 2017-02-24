<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartureTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('departure', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('warehouse_id');
            $table->integer('responsable_id');
            $table->integer('supplier_id');
            $table->integer('city_id');
            $table->integer('destination_id');
            $table->string('consecutive');
            $table->string('order');
            $table->string('address');
            $table->string('phone');
            $table->dateTime('created');
            $table->string('status_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('departure');
    }

}
