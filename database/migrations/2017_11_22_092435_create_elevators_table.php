<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElevatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elevators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entry_id');
            $table->string('identifier');
            $table->string('type')->nullable();
            $table->string('made_in')->nullable();
            $table->string('company')->nullable();
            $table->foreign('entry_id')->references('id')->on('entries')->onDelete('cascade');
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
