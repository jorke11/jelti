<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stakeholder_id');
            $table->integer('commercial_id');
            
            $table->integer('source_id')->nullable();
            $table->integer('city_id');

            $table->string('name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('position')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->dateTime('birth_date')->nullable();
            $table->string('web_site')->nullable();
            $table->string('id_skype')->nullable();
            $table->string('id_twitter')->nullable();
            $table->string('address');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('contacts');
    }

}
