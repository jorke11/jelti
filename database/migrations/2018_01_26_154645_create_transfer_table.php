<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('transfer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('origin_id');
            $table->integer('destination_id');
            $table->dateTime('created');
            $table->dateTime('date_dispatched');
            $table->integer('status_id');
            $table->integer('insert_id');
            $table->integer('update_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('transfer');
    }

}
