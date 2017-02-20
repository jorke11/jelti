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
            $table->integer('typemenu_id');
            $table->string('description');
            $table->string('controller');
            $table->string('icon');
            $table->integer('priority');
            $table->string('title')->nullable();
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
        Schema::dropIfExists('permission');
    }

}
