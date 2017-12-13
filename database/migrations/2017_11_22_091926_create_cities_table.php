<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\City;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        $names = ['Deçan','Dragash','Ferizaj','Fushë Kosovë','Gllogoc',
        'Graçanicë','Gjakovë','Gjilan','Hani i Elezit','Istog','Junik',
        'Kaçanik','Kamenicë','Klinë','Kllokot','Leposaviq','Lipjan','Malishevë',
        'Mamushë','Mitrovicë','Novobërdë','Obiliç','Partesh','Pejë','Podujevë',
        'Prishtinë','Prizren','Rahovec','Ranillug','Skënderaj','Suharekë',
        'Shtërpc','Shtime','Viti','Vushtrri','Zubin Potok','Zveçan'];

        for ($i=0; $i < count($names); $i++) { 
            $city = new City();
            $city->name = $names[$i];
            $city->save();
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
