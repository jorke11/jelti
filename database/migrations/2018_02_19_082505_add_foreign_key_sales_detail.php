<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeySalesDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('sales_detail', function (Blueprint $table) {
            $table->foreign("product_id")->references("id")->on("products");
            $table->foreign("sale_id")->references("id")->on("sales");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('sales_detail', function (Blueprint $table) {
            $table->dropForeign("product_id");
            $table->dropForeign("sale_id");
        });
    }
}
