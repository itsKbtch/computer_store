<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesPCTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('des_pc', function (Blueprint $table) {
            $table->unsignedSmallInteger('id');
            $table->unsignedTinyInteger('brand_id');
            $table->string('CPU', 255);
            $table->unsignedTinyInteger('CPU_group_id');
            $table->tinyInteger('RAM_capacity');
            $table->string('RAM_type', 50);
            $table->tinyInteger('RAM_slots');
            $table->string('HD_capacity', 50);
            $table->unsignedTinyInteger('HD_type_id');
            $table->string('VGA', 255);
            $table->unsignedTinyInteger('VGA_group_id');
            $table->string('ports', 255);
            $table->string('os', 50);
            $table->string('lan', 50);
            $table->string('wifi', 50)->nullable();
            $table->string('bluetooth', 50)->nullable();
            $table->string('measurements', 50)->nullable();
            $table->tinyInteger('weight')->nullable();
            $table->string('material', 50)->nullable();
            $table->string('others', 255)->nullable();

            $table->primary('id');
            $table->foreign('id')->references('id')->on('product');
            $table->foreign('CPU_group_id')->references('id')->on('cpu_group');
            $table->foreign('HD_type_id')->references('id')->on('hd_type');
            $table->foreign('VGA_group_id')->references('id')->on('vga_group');
            $table->foreign('brand_id')->references('id')->on('brand');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('des_pc');
    }
}
