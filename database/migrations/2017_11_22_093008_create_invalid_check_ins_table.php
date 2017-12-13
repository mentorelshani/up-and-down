<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvalidCheckInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invalid_check_ins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('relay_id');
            $table->integer('site_code');
            $table->integer('site_number');
            $table->string('validity');
            $table->foreign('relay_id')->references('id')->on('relays')->onDelete('cascade');
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
        //
    }
}
