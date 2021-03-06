<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryLogTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('row_id');
            $table->integer('warehouse_id');
            $table->decimal('value', 15, 2);
            $table->date('expiration_date');
            $table->integer('quantity');
            $table->integer('previous_quantity')->nullable();
            $table->string('type_move');
            $table->text('lot');
            $table->text('description')->nullable();
            $table->integer('insert_id');
            $table->integer('update_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('inventory_log');
    }

}
