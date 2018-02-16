<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeparturesDetailTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('departures_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('departure_id');
            $table->integer('product_id');
            $table->integer('status_id');
            $table->integer('quantity');
            $table->integer('real_quantity')->nullable();
            $table->decimal('value', 15, 2);
            $table->decimal('tax', 5, 2);
            $table->decimal('units_sf', 15, 2)->nullable();
            $table->string('description')->nullable();
            $table->json("quantity_lots")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('departures_detail');
    }

}
