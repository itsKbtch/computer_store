<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone_number', 15);
            $table->string('email')->nullable();
            $table->string('address', 255)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('total');
            $table->tinyInteger('discount_percent')->default(0)->nullable();
            $table->integer('discount_cash')->default(0)->nullable();
            $table->integer('total_with_discount');           
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}
