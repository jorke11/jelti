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
            $table->string('name');
            $table->string('address_invoice');
            $table->string('address_send');
            $table->integer('invoice_city_id');
            $table->integer('send_city_id');
            $table->string('email');
            $table->string('term');
            $table->string('mobile');
            $table->text('business_name');
            $table->string('nit');
            $table->integer('verification');
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
