<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Elevator;

class ElevatorController extends Controller
{
    public function add(Request $request){

        $this->validate($request,[
            'entry_id' => 'required|integer',
            'identifier' => 'required'
        ]);

        $entry_id = $request->entry_id;
        $identifier = $request->identifier;
        $type = $request->type;
        $made_in = $request->made_in;
        $company = $request->company;

        $elevator = new Elevator();
        $elevator->entry_id = $entry_id;
        $elevator->identifier = $identifier;
        $elevator->type = $type;
        $elevator->made_in = $made_in;
        $elevator->company = $company;
        $elevator->save();

        return $elevator;
    }
}
