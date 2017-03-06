<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('warehouse_id');
            $table->integer('responsible_id');
            $table->integer('departure_id')->nullable();
            $table->integer('city_id');
            $table->integer('client_id');
//            $table->integer('branch_id');
            $table->integer('destination_id');
            $table->string('phone');
            $table->string('status_id');
            $table->string('address');
            $table->string('description')->nullable();
            $table->dateTime('created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sales');
    }

}
