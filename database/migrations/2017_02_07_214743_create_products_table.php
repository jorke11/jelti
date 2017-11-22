<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('supplier_id');
            $table->integer('account_id')->nullable();
            $table->string('title', 120);
            $table->text('description');
            $table->text('short_description');
            $table->integer('reference');
            $table->integer('alias_reference')->nullable();
            $table->decimal('units_supplier', 15, 2);
            $table->decimal('units_sf', 15, 2);
            $table->decimal('cost_sf', 15, 2);
            $table->decimal('tax', 15, 2);
            $table->decimal('price_sf', 15, 2);
            $table->string('url_part', 60)->nullable();
            $table->string('bar_code', 30);
            $table->integer('status_id');
            $table->string('meta_title', 100)->nullable();
            $table->string('meta_keywords', 100)->nullable();
            $table->string('meta_description', 100)->nullable();
            $table->integer('minimum_stock')->nullable();
            $table->json('characteristic')->nullable();
            $table->string('image')->nullable();
            $table->integer('margin_sf')->nullable();
            $table->json('warehouse')->nullable();
            $table->integer('pvp')->nullable();
            $table->boolean('is_new')->nullable();
            $table->text('about')->nullable();
            $table->text('why')->nullable();
            $table->text('ingredients')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products');
    }

}
