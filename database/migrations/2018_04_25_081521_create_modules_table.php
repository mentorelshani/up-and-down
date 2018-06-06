<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Module;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('url');
            $table->string('icon');
            $table->timestamps();
        });

        $modules = ['Buildings','Users','Cards','Access point','Entries'];

        foreach ($modules as $module) {
            $module1 = new Module();
            $module1->name = $module;
            $module1->url = str_replace(' ', '-',strtolower($module));
            $module1->icon = $module1->url;
            $module1->save();
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
