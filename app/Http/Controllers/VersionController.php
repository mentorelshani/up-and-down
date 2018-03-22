<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Version;

class VersionController extends Controller
{
    public function getVersions(){
        return Version::get();
    }

    public function add(Request $request){

        // return "Bott !";

        $this->validate($request,[
            'name' => 'required',
            'number_of_relays' => 'integer'
        ]);

        $name = $request->name;
        $number_of_relays = $request->number_of_relays;

        $version = new Version();
        $version->name = $name;
        $version->number_of_relays = $number_of_relays;
        $version->save();

        return $version;
    }
}
