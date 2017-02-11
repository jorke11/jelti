<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('permission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->string('description');
            $table->string('controller');
            $table->string('title');
            $table->string('alternative');
            $table->boolean('event');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('permission');
    }

}
