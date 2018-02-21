<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyDeparturesDetail extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('departures_detail', function (Blueprint $table) {
            $table->foreign("product_id")->references("id")->on("products");
            $table->foreign("departure_id")->references("id")->on("departures");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('departures_detail', function (Blueprint $table) {
            $table->dropForeign("product_id");
            $table->dropForeign("departure_id");
        });
    }

}
