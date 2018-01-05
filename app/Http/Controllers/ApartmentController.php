<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;

class ApartmentController extends Controller
{
    public function getApartment($id){
        return Apartment::whereId($id)->first();
    }

    public function getApartmentsByEntry($entry_id){

        return Apartment::where('entry_id',$entry_id)->get();
    }

    public function add(Request $request){

        $this->validate($request,[
            'entry_id' => 'required|integer',
            'door_number' => 'required|integer'
        ]);

        $entry_id = $request->entry_id;
        $door_number = $request->door_number;

        $apartment = new Apartment();
        $apartment->entry_id = $entry_id;
        $apartment->door_number = $door_number;
        $apartment->save();

        return $apartment;
    }

    public function delete($id){

        $a = Apartment::find($id);

        if ($a != null) {
            $a->delete();
            return "u fshi";
        }
        return "Nuk ekziston";
    }
}
