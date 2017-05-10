<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->integer('typemenu_id');
            $table->string('description')->nullable();
            $table->string('controller')->nullable();
            $table->string('icon')->nullable();
            $table->integer('priority');
            $table->string('title');
            $table->string('alternative')->nullable();
            $table->boolean('event')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('permissions');
    }

}
