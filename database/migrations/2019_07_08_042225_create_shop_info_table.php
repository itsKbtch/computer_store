<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_info', function (Blueprint $table) {
            $table->tinyIncrements('id');

            $table->string('phone_number', 15);
            $table->string('email');
            $table->string('address', 255);
            $table->string('facebook');
            $table->string('open_time');
            $table->text('about');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_info');
    }
}
