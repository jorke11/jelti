<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesdetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entriesdetail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('products_id');
            $table->integer('cantidad');
            $table->dateTime('created');
            $table->decimal('value',15,2);
            $table->integer('categories_id'); 
             $table->integer('supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entriesdetail');
    }
}
