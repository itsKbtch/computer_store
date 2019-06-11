<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplyPromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apply_promo', function (Blueprint $table) {
            $table->unsignedTinyInteger('promo_id');
            $table->unsignedSmallInteger('product_id');

            $table->primary(['promo_id', 'product_id']);
            $table->foreign('promo_id')->references('id')->on('promotion');
            $table->foreign('product_id')->references('id')->on('product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apply_promo');
    }
}
