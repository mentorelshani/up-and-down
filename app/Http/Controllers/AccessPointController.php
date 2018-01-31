<?php

namespace App\Http\Controllers;

use App\Http\Requests\addAccessPointRequest;
use App\Http\Requests\updateAccessPointRequest;
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
}
