<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Relay;
use App\Models\Access_point;

class RelayController extends Controller
{
    public function addRelays(Request $request){

        $this->validate($request,[
            'relays' => 'required|array',
            'access_point_id' => 'required|integer',
        ]);

        $access_point_id = $request->access_point_id;
        $relays = $request->relays;


        for ($i = 0; $i < count($relays); $i++ ){
            $relay = new Relay();
            $relay->access_point_id = $access_point_id;
            $relay->relay = $relays[$i]['relay'];
            $relay->floor = $relays[$i]['floor'];
            $relay->pulse_time = $relays[$i]['pulse_time'];
            $relay->save();
        }

        $access_point = Access_point::with('relays')->where('id',$access_point_id)->first();

        return $access_point;
    }
}
