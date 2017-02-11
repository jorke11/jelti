<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsecutiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consecutive', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->integer('type_form');
            $table->integer('initial');
            $table->integer('final');
            $table->integer('current');
            $table->integer('large');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consecutive');
    }
}
