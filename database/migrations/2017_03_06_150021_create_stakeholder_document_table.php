<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStakeholderDocumentTable extends Migration
{
    public function up() {
        Schema::create('stakeholder_document', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stakeholder_id');
            $table->integer('document_id');
            $table->string('path');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('stakeholder_document');
    }
}
