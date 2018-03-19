<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Role;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by')->nullable();
            $table->string('name');
            $table->boolean('payments');
            $table->boolean('buildings');
            $table->boolean('access_points');
            $table->boolean('clients');
            $table->boolean('cards');
            $table->boolean('users');
            $table->timestamps();
        });

        $role = new Role();
        $role->name = "Admin";
        $role->save();
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
