<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyBranchDeparture extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('departures', function (Blueprint $table) {
            $table->foreign("branch_id")->references("id")->on("branch_office");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('departures', function (Blueprint $table) {
            $table->dropForeign("branch_id");
        });
    }

}
