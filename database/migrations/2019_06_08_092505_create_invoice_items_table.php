<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->unsignedInteger('invoice_id');
            $table->unsignedSmallInteger('product_id');
            $table->tinyInteger('quantity');
            $table->tinyInteger('discount_percent')->default(0)->nullable();
            $table->integer('discount_cash')->default(0)->nullable();

            $table->primary(['invoice_id', 'product_id']);
            $table->foreign('invoice_id')->references('id')->on('invoice');
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
        Schema::dropIfExists('invoice_items');
    }
}
