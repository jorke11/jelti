<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchagedetailTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('purchage_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchage_id');
            $table->integer('entry_id')->nullable();
            $table->integer('product_id');
            $table->integer('category_id');
            $table->integer('quantity');
            $table->dateTime('expiration_date');
            $table->decimal('value', 15, 2);
            $table->decimal('tax', 15, 2);
            $table->string('lot');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('purchage_detail');
    }

}
