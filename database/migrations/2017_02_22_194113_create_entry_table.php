<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntryTable extends Migration
{
    public function up() {
        Schema::create('entry', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('warehouse_id');
            $table->integer('responsable_id');
            $table->integer('supplier_id');
            $table->integer('city_id');
            $table->string('description');
//            $table->string('consecutive');
            $table->string('avoice');
            $table->dateTime('created');
            $table->integer('status_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('entry');
    }
}
