<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commercial_id');
            $table->string('subject');
            $table->datetime('expiration_date');
            $table->integer('contact_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('priority_id')->nullable();
            $table->string('business_name')->nullable();
            $table->json('notification')->nullable();
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
         Schema::dropIfExists('activities');
    }
}
