<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesOtherAccessoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('des_other_accessory', function (Blueprint $table) {
            $table->unsignedSmallInteger('id');
            $table->string('description', 255)->nullable();

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
        Schema::dropIfExists('des_other_accessory');
    }
}
