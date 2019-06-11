<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesScreenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('des_screen', function (Blueprint $table) {
            $table->unsignedSmallInteger('id');
            $table->string('brand', 50)->nullable();
            $table->string('size', 50)->nullable();
            $table->string('resolution', 50)->nullable();
            $table->string('tech', 50)->nullable();

            $table->primary('id');
            $table->foreign('id')->references('id')->on('product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('des_screen');
    }
}
