<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStakeholderTable extends Migration {

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
            $table->integer('city_id')->nullable();
            $table->integer('status_id');
            $table->integer('type_document')->nullable();
            $table->integer('responsible_id')->nullable();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('document')->nullable();
            $table->integer('verification')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('business_name')->nullable();
            $table->string('business')->nullable();
            $table->string('contact')->nullable();
            $table->string('phone_contact')->nullable();
            $table->integer('term')->nullable();
            $table->string('web_site')->nullable();
            $table->integer('lead_time')->nullable();
            $table->integer("user_insert");
            $table->integer("user_update")->nullable();
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
