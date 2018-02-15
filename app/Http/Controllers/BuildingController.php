<?php

namespace App\Http\Controllers;

use App\Http\Requests\addBuildingRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\updateBuildingRequest;
use App\Http\Services\BuildingService;
use DB;
use Illuminate\Http\Request;
use App\Models\Building;

class BuildingController extends Controller
{
    private $buildingService;

    public function __construct(BuildingService $buildingService){

        $this->buildingService = $buildingService;
    }

    public function getAllBuildings (){

    	$buildings = Building::join('addresses','addresses.id','=','buildings.address_id')
                        ->join('cities','cities.id','=','addresses.city_id')
                        ->whereHasAccess()
                        ->get();

        return $buildings;
    }

    public function index(PaginateRequest $request){

        $orderBy = $request->orderBy;
        $limit = $request->limit;
        $page = $request->page;
        $relation = $request->relation;
        $value = $request->value;
        $asc = $request->asce  ? 'asc' : 'desc';

        $skip = ($page - 1) * $limit;

        $buildings = Building::join('addresses','addresses.id','=','buildings.address_id')
            ->join('cities','cities.id','=','addresses.city_id')
            ->join('entries','buildings.id','=','entries.building_id')
            ->join('apartments','entries.id','=','apartments.entry_id')
            ->join('clients','apartments.id','=','clients.apartment_id')
            ->join('cards','clients.id','=','cards.client_id')
            ->join('elevators','entries.id','=','elevators.entry_id')
            ->join('access_points','elevators.id','=','access_points.elevator_id');

        foreach ($relation as $i) {
            $buildings = $buildings->orWhereRaw("cast($i as text) like '%$value%'");
        }

        $buildings = $buildings->whereHasAccess()
                               ->select(['buildings.*','cities.name as city','addresses.street','addresses.neighborhood'])
                               ->distinct()
                               ->orderBy($orderBy,$asc);

        $count = $buildings->get()->count();

        $result = $buildings->skip($skip)->take($limit)->get();

        return array('count' => $count, 'buildings' => $result);
    }

    public function getBuilding($id){

        return Building::whereHasAccess()->whereId($id)->with('address.city','entries')->first();
    }

    public function add(addBuildingRequest $request){

        $building = new Building();

        $this->buildingService->add($request, $building);

        if($request->hasFile('file')){

            $this->validate($request,[
                'file' => 'image'
            ]);

            $image = $request->file('file');

            $fileName = "$building->id.png";

            $image->move(public_path("/uploads"), $fileName);
        }

        return $building;
    }

    public function update(updateBuildingRequest $request){

        $building = Building::find($request->id);

        $this->buildingService->add($request, $building);

        return $building;
    }

    public function destroy($id){

        $a = Building::find($id);
        
        if ($a != null) {
            $a->delete();
            return "u fshi";
        }
        return "nuk ekziston";
    }

}
