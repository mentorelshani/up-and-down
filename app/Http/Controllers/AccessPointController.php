<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Access_point;

class AccessPointController extends Controller
{
    public function add(Request $request){

        $this->validate($request,[
            'elevator_id' => 'required|integer',
            'version_id' => 'required|integer',
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
}
