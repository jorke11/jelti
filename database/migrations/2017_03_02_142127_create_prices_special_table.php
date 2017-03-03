<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesSpecialTable extends Migration
{
      /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('prices_special', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('product_id');
            $table->integer('price_sf');
            $table->decimal('margin',10,2);
            $table->decimal('margin_sf',10,2);
            $table->decimal('tax',10,2);
            $table->boolean('priority')->nullable();
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('prices_special');
    }
}
