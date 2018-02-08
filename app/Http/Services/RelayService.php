<?php
/**
 * Created by PhpStorm.
 * User: Mentori
 * Date: 1/29/2018
 * Time: 10:42 AM
 */

namespace App\Http\Services;


class RelayService
{
    public function add($request, $relay){

        $relay->access_point_id = $request->access_point_id;
        $relay->relay = $request->relay;
        $relay->floor = $request->floor;
        $relay->pulse_time = $request->pulse_time;
        $relay->save();
    }

    public function update($request, $relay){

        $relay->access_point_id = $request->access_point_id;
        $relay->relay = $request->relay;
        $relay->floor = $request->floor;
        $relay->pulse_time = $request->pulse_time;
        $relay->update();
    }
}