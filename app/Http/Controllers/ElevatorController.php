<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Elevator;

class ElevatorController extends Controller
{
    public function getElevatorsByEntry($entry_id){
        return Elevator::where('entry_id',$entry_id)->get();
    }

    public function getElevator($id){
        return Elevator::whereId($id)->first(

        );
    }

    public function add(Request $request){

        $this->validate($request,[
            'entry_id' => 'exists:entries,id',
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

    public function update(Request $request){

        $this->validate($request,[
            'id' => 'exists:elevators',
            'entry_id' => 'exists:entries,id',
            'identifier' => 'required'
        ]);

        $id = $request->id;
        $entry_id = $request->entry_id;
        $identifier = $request->identifier;
        $type = $request->type;
        $made_in = $request->made_in;
        $company = $request->company;

        $elevator = Elevator::whereId($id)->first();
        $elevator->entry_id = $entry_id;
        $elevator->identifier = $identifier;
        $elevator->type = $type;
        $elevator->made_in = $made_in;
        $elevator->company = $company;
        $elevator->update();

        return $elevator;
    }

    public function destroy($id){

        $a = Elevator::find($id);

        if ($a != null) {
            $a->delete();
            return "u fshi";
        }
        return "Nuk ekziston";
    }
}