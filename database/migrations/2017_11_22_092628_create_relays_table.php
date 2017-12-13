<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relays', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('access_point_id');
            $table->string('relay');
            $table->string('floor');
            $table->double('pulse_time', 3, 3);
            $table->foreign('access_point_id')->references('id')->on('access_points')->onDelete('cascade');
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
