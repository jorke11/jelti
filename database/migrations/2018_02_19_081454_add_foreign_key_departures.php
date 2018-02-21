<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyDepartures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('departures', function (Blueprint $table) {
            $table->foreign("city_id")->references("id")->on("cities");
            $table->foreign("destination_id")->references("id")->on("cities");
            $table->foreign("client_id")->references("id")->on("stakeholder");
            $table->foreign("warehouse_id")->references("id")->on("warehouses");
            $table->foreign("responsible_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('departures', function (Blueprint $table) {
            $table->dropForeign("city_id");
            $table->dropForeign("client_id");
            $table->dropForeign("warehouse_id");
            $table->dropForeign("responsible_id");
            $table->dropForeign("destination_id");
        });
    }

}
