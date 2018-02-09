<?php

namespace App\Http\Controllers;

use App\Http\Requests\addRelayRequest;
use App\Http\Requests\updateRelayRequest;
use App\Http\Services\RelayService;
use Illuminate\Http\Request;
use App\Models\Relay;
use App\Models\Access_point;

class RelayController extends Controller
{
    private $relayService;

    public function __construct(RelayService $relayService){

        $this->relayService = $relayService;
    }

    public function getRelays($access_point_id){

        return Relay::where('access_point_id',$access_point_id)->orderBy('relay')->get();
    }

    public function getRelaysByElevatorId($elevator_id){
        $access_points = Access_point::where('elevator_id',$elevator_id)->get(['id']);

        return Relay::whereIn('access_point_id',$access_points)->orderBy('relay')->get();
    }

    public function getRelay($id){

        return Relay::whereId($id)->first();
    }

    public function findRelay($access_point_id, $relay){

        return Relay::where('access_point_id', $access_point_id)->where('relay',$relay)->first();
    }

    public function add(addRelayRequest $request){

        $relay = new Relay();

        $this->relayService->add($request, $relay);

        return $relay;
    }

    public function update(updateRelayRequest $request){

        $relay = Relay::find($request->id);

        $this->relayService->update($request, $relay);

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
