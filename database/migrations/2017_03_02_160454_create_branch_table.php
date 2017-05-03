<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('branch_office', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stakeholder_id');
            $table->integer('city_id');
            $table->string('web_site');
            $table->string('name')->nullable();
            $table->string('address_invoice')->nullable();
            $table->string('address_send')->nullable();
            $table->integer('invoice_city_id')->nullable();
            $table->integer('send_city_id')->nullable();
            $table->string('email')->nullable();
            $table->string('term')->nullable();
            $table->string('mobile')->nullable();
            $table->text('business_name')->nullable();
            $table->integer('verification');
            $table->integer('user_insert');
            $table->string('document');
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
        Schema::dropIfExists('branch_office');
    }

}
