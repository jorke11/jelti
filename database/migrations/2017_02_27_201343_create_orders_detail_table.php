<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersDetailTable extends Migration { /**
 * Run the migrations.
 *
 * @return void
 */

    public function up() {
        Schema::create('orders_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('product_id');
            $table->integer('quantity');
            $table->decimal('tax', 15, 2);
            $table->decimal('value', 15, 2);
            $table->decimal('units_sf', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('orders_detail');
    }

}
