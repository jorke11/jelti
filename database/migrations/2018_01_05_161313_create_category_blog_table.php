<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryBlogTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('categories_blog', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('image')->nullable();
            $table->integer('order')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('type_category_id')->nullable();
            $table->integer('banner')->nullable();
            $table->integer('node_id')->nullable();
            $table->string('short_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('categories_blog');
    }

}
