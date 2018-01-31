<?php

namespace App\Http\Controllers;

use App\Http\Requests\addElevatorRequest;
use App\Http\Requests\updateElevatorRequest;
use App\Http\Services\ElevatorService;
use Illuminate\Http\Request;
use App\Models\Elevator;

class ElevatorController extends Controller
{
    private $elevatorService;

    public function __construct(ElevatorService $elevatorService){

        $this->elevatorService = $elevatorService;
    }

    public function getElevatorsByEntry($entry_id){
        return Elevator::where('entry_id',$entry_id)->get();
    }

    public function getElevator($id){
        return Elevator::whereId($id)->first();
    }

    public function add(addElevatorRequest $request){

        $elevator = new Elevator();

        $this->elevatorService->add($request, $elevator);

        return $elevator;
    }

    public function update(updateElevatorRequest $request){

        $elevator = Elevator::find($request->id);

        $this->elevatorService->update($request, $elevator);

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