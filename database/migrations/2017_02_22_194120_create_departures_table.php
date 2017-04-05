<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeparturesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('departures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('warehouse_id');
            $table->integer('responsible_id');
            $table->integer('client_id');
            $table->integer('city_id');
            $table->integer('destination_id');
            $table->integer('order_id')->nullable();
            $table->integer('branch_id');
            $table->string('address');
            $table->string('consecutive');
            $table->string('phone');
            $table->dateTime('created');
            $table->integer('status_id');
            $table->string('invoice')->nullable();
            $table->boolean('pdf_create')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('departures');
    }

}
