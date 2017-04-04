<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesDetailTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('entries_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entry_id');
            $table->integer('product_id');
            $table->integer('quantity');
            $table->integer('real_quantity')->nullable();
            $table->dateTime('expiration_date')->nullable();
            $table->decimal('value', 15, 2);
            $table->string('lot')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('entries_detail');
    }

}
