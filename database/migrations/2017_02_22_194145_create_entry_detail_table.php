<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntryDetailTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('entry_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entry_id');
            $table->integer('product_id');
            $table->integer('category_id');
            $table->integer('quantity');
            $table->dateTime('expiration_date');
            $table->decimal('value', 15, 2);
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
        Schema::dropIfExists('entry_detail');
    }

}
