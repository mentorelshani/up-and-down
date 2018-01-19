<?php

namespace App\Http\Services;

class AccessPointService
{


    public function add($request, $access_point)
    {
        $access_point->elevator_id =$request->elevator_id;
        $access_point->version_id = $request->version_id;
        $access_point->IMEI = $request->IMEI;
        $access_point->phone_number = $request->phone_number;
        $access_point->notes = $request->notes;
        $access_point->save();
    }

    public function update($request, $access_point)
    {
        $access_point->elevator_id =$request->elevator_id;
        $access_point->version_id = $request->version_id;
        $access_point->IMEI = $request->IMEI;
        $access_point->phone_number = $request->phone_number;
        $access_point->notes = $request->notes;
        $access_point->update();
    }

}