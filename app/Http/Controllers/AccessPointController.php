<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Access_point;
use App\Models\Elevator;

class AccessPointController extends Controller
{
    public function getAccessPoint($id){

        return Access_point::whereId($id)->first();
    }

    public function getAccessPointsByEntry($entry_id){

        $elevator_ids = Elevator::where('entry_id',$entry_id)->select('id')->get();
        $access_points = Access_point::whereIn('elevator_id',$elevator_ids)->with('elevator','version')->get();

        return $access_points;
    }

    public function add(Request $request){

        $this->validate($request,[
            'elevator_id' => 'exists:elevators,id',
            'version_id' => 'exists:versions,id',
            'IMEI' => 'required|integer',
            'phone_number' => 'required'
        ]);

        $elevator_id = $request->elevator_id;
        $version_id = $request->version_id;
        $IMEI = $request->IMEI;
        $phone_number = $request->phone_number;
        $notes = $request->notes;

        $access_point = new Access_point();
        $access_point->elevator_id = $elevator_id;
        $access_point->version_id = $version_id;
        $access_point->IMEI = $IMEI;
        $access_point->phone_number = $phone_number;
        $access_point->notes = $notes;
        $access_point->save();

        return $access_point;

    }

    public function update(Request $request){
        $this->validate($request,[
            'id' => 'exists:access_points',
            'elevator_id' => 'required|integer',
            'version_id' => 'required|integer',
            'IMEI' => 'required|integer',
            'phone_number' => 'required'
        ]);

        $id = $request->id;
        $elevator_id = $request->elevator_id;
        $version_id = $request->version_id;
        $IMEI = $request->IMEI;
        $phone_number = $request->phone_number;
        $notes = $request->notes;

        $access_point = Access_point::whereId($id)->first();

        $access_point->elevator_id = $elevator_id;
        $access_point->version_id = $version_id;
        $access_point->IMEI = $IMEI;
        $access_point->phone_number = $phone_number;
        $access_point->notes = $notes;
        $access_point->update();

        return $access_point;
    }

    public function destroy($id){
        $a = Access_point::find($id);

        if ($a != null) {
            $a->delete();
            return "u fshi";
        }
        return "Nuk ekziston";
    }
}
