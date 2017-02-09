<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last_name');
            $table->string('document');
            $table->string('email');
            $table->string('address');
            $table->string('phone');
            $table->string('contact')->nullable();
            $table->string('phone_contact')->nullable();
            $table->integer('term');
            $table->integer('city_id');
            $table->string('web_site')->nullable();
            $table->integer('type_regime_id');
            $table->integer('type_person_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('suppliers');
    }

}
