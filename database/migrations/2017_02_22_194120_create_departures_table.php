<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeparturesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('departures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('warehouse_id');
            $table->integer('responsible_id');
            $table->integer('client_id');
            $table->integer('city_id');
            $table->integer('destination_id');
            $table->integer('order_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->string('address');
            $table->string('description');
            $table->string('transport');
            $table->string('phone');
            $table->dateTime('created');
            $table->dateTime('date_dispatched');
            $table->integer('status_id');
            $table->integer('insert_id');
            $table->integer('update_id')->nullable();
            $table->integer('remission')->nullable();
            $table->string('invoice')->nullable();
            $table->decimal('shipping_cost', 15, 2)->nullable();
            $table->decimal('outstanding', 15, 2)->nullable();
            $table->boolean('pdf_create')->nullable();
            $table->boolean('paid_out')->nullable();
            $table->text('voucher')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('type_insert_id');
            $table->string('type_request')->nullable();
            $table->timestamps();
            $table->dateTime('dispatched');
            $table->string('purchase_order');
            $table->date('date_appointment');
            $table->unique('invoice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('departures');
    }

}
