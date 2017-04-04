<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesdetailTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('purchases_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id');
            $table->integer('entry_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('voucher_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('type_nature');
            $table->decimal('value', 15, 2);
            $table->decimal('tax', 15, 2)->nullable();
            $table->string('description')->nullable();
            $table->integer("order");
            $table->boolean("payed")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('purchases_detail');
    }

}
