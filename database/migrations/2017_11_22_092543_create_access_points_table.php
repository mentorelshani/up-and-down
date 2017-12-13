<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('elevator_id');
            $table->integer('version_id');
            $table->string('IMEI');
            $table->string('phone_number');
            $table->string('notes')->nullable();
            $table->foreign('elevator_id')->references('id')->on('elevators')->onDelete('cascade');            
            $table->foreign('version_id')->references('id')->on('versions')->onDelete('cascade');
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
