<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 255);
            $table->unsignedTinyInteger('type_id');
            $table->integer('price');
            $table->tinyInteger('warranty')->nullable();
            $table->unsignedTinyInteger('group_id')->nullable();
            $table->tinyInteger('in_stock')->default(0)->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->float('rate', 2, 1)->default(0)->nullable();
            $table->integer('rate_count')->default(0)->nullable();
            $table->tinyInteger('discount_percent')->default(0)->nullable();
            $table->integer('discount_cash')->default(0)->nullable();
            $table->dateTime('discount_end_time')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('product_type');
            $table->foreign('group_id')->references('id')->on('product_group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
