<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStakeholderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('stakeholder', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_regime_id')->nullable();
            $table->integer('type_person_id')->nullable();
            $table->integer('type_stakeholder');
            $table->integer('city_id');
            $table->integer('status_id');
            $table->integer('type_document')->nullable();
            $table->integer('commercial_id')->nullable();
            $table->string('name');
            $table->string('last_name');
            $table->string('document')->nullable();
            $table->string('email');
            $table->string('address');
            $table->string('phone');
            $table->string('bussines_name')->nullable();
            $table->string('contact')->nullable();
            $table->string('phone_contact')->nullable();
            $table->integer('term')->nullable();
            $table->string('web_site')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('stakeholder');
    }
}
