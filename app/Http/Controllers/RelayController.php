<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Relay;
use App\Models\Access_point;

class RelayController extends Controller
{
    public function getRelays($access_point_id){
        return Relay::where('access_point_id',$access_point_id)->get();
    }

    public function getRelay($id){

        return Relay::whereId($id)->first();
    }

    public function findRelay($access_point_id, $relay){

        return Relay::where('access_point_id',$access_point_id)->where('relay',$relay)->first();
    }

    public function add(Request $request){

        $this->validate($request,[
            'access_point_id' => 'required|exists:access_points,id',
            'relay' => 'required|max:30',
            'floor' => 'required|max:30',
            'pulse_time' => 'required|numeric',
        ]);

        $access_point_id = $request->access_point_id;
        $relay_name = $request->relay;
        $floor = $request->floor;
        $pulse_time = $request->pulse_time;

        $relay = new Relay();
        $relay->access_point_id = $access_point_id;
        $relay->relay = $relay_name;
        $relay->floor = $floor;
        $relay->pulse_time = $pulse_time;
        $relay->save();

        return $relay;
    }

    public function update(Request $request){

        $this->validate($request,[
            'id' => 'required|exists:relays',
            'relay' => 'required|max:30',
            'floor' => 'required|max:30',
            'pulse_time' => 'required|numeric',
        ]);

        $id = $request->id;
        $relay_name = $request->relay;
        $floor = $request->floor;
        $pulse_time = $request->pulse_time;

        $relay = Relay::whereId($id)->first();

        $relay->relay = $relay_name;
        $relay->floor = $floor;
        $relay->pulse_time = $pulse_time;
        $relay->update();

        return $relay;
    }

    public function destroy($id){
        $relay = Relay::find($id);

        if ($relay != null) {
            $relay->delete();
            return "u fshi";
        }
        return "Nuk ekziston";
    }

}
