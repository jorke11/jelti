<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesDetailTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sales_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id');
            $table->integer('product_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('tax', 15, 2)->nullable();
            $table->integer('account_id');
            $table->integer('order');
            $table->decimal('value', 15, 2);
            $table->string('description')->nullable();
            $table->boolean("payed")->nullable();
            $table->integer("type_nature");
            $table->integer("parent_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sales_detail');
    }

}
