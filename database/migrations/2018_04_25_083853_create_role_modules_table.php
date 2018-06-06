<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Module;
use App\Models\Role_modules;

class CreateRoleModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('role_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id');
            $table->integer('module_id');
            $table->boolean('read');
            $table->boolean('write');
            $table->boolean('delete');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->timestamps();
        });

        $modules = Module::get();

        foreach ($modules as $module){
            $role_module = new Role_modules();
            $role_module->role_id = 1;
            $role_module->module_id = $module->id;
            $role_module->read = true;
            $role_module->write = true;
            $role_module->delete = true;
            $role_module->save();
        }

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
