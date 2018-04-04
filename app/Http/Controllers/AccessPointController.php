<?php

namespace App\Http\Controllers;

use App\Http\Requests\addAccessPointRequest;
use App\Http\Requests\updateAccessPointRequest;
use App\Models\Card_access;
use App\Models\Relay;
use App\Models\Version;
use Illuminate\Http\Request;
use App\Models\Access_point;
use App\Models\Elevator;
use App\Http\Services\AccessPointService;

class AccessPointController extends Controller
{
    private $accessPointService;

    public function __construct(AccessPointService $accessPointService){

        $this->accessPointService = $accessPointService;
    }

    public function getAccessPoint($id){

        return Access_point::whereId($id)->with(['elevator','version','relays'])->first();
    }

    public function getAccessPointsByEntry($entry_id){

        $elevator_ids = Elevator::where('entry_id',$entry_id)->select('id')->get();

        $access_points = Access_point::whereIn('elevator_id',$elevator_ids)->with('elevator','version')->get();

        return $access_points;
    }

    public function getAccessPointsByElevator($elevator_id){

        return Access_point::where('elevator_id', $elevator_id)->get();
    }

    public function add(addAccessPointRequest $request){

        $access_point = new Access_point();

        $this->accessPointService->add($request, $access_point);

        $version = Version::find($request->version_id);

        for ($i = 0; $i < $version->number_of_relays; $i++){
            $relay = new Relay();
            $relay->access_point_id = $access_point->id;
            $relay->relay = $i+1;
            $relay->save();
        }

        return Access_point::whereId($access_point->id)->with(['elevator','version','relays'])->first();
    }

    public function update(updateAccessPointRequest $request){

        $access_point = Access_point::find($request->id);

        $this->accessPointService->update($request, $access_point);

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

    public function cloneAccessPoint(Request $request, $id){

        $access_point1 = Access_point::whereId($id)->with('relays.card_accesses')->first();

        $access_point2 = new Access_point();
        $access_point2->imei = $request->imei;
        $access_point2->elevator_id = $request->elevator_id;
        $access_point2->version_id = $request->version_id;
        $access_point2->phone_number = $request->phone_number;
        $access_point2->notes = $request->notes;
        $access_point2->active = true;
        $access_point2->save();

        foreach ($access_point1->relays as $relay1){
            $relay2 = new Relay();
            $relay2->access_point_id = $access_point2->id;
            $relay2->relay = $relay1->relay;
            $relay2->floor = $relay1->floor;
            $relay2->pulse_time = $relay1->pulse_time;
            $relay2->save();

            foreach ($relay1->card_accesses as $card_access1){
                $card_access2 = new Card_access();
                $card_access2->relay_id = $relay2->id;
                $card_access2->card_id = $card_access1->card_id;
                $card_access2->save();
            }
        }

        return $access_point2->load('relays.card_accesses');
    }
}
