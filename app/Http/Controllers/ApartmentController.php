<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;

class ApartmentController extends Controller
{
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
}
