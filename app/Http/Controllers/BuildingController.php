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

    public function getBuildings (PaginateRequest $request){

        // return Buildings where Auth::user() has permission
//        return $request->rules();

    	$orderBy = $request->orderBy;
    	$limit = (int) $request->limit;
    	$page = (int) $request->page;
    	$relation = $request->relation;
    	$value = $request->value;
    	$asc = (bool)$request->asce  ? 'asc' : 'desc';


    	$skip = ($page - 1) * $limit;

    	$buildings = Building::join('addresses','addresses.id','=','buildings.address_id')
                        ->join('cities','cities.id','=','addresses.city_id')
                        ->where($relation,'ilike','%'.$value.'%')
                        ->whereHasAccess()
                        ->orderBy($orderBy,$asc);


        $count = $buildings->get()->count();

        $result = $buildings->skip($skip)->take($limit)
                            ->get(['buildings.*','cities.name as city','addresses.street','addresses.neighborhood']);

        return array('count' => $count, 'buildings' => $result);
    }
    public function index(PaginateRequest $request){

        $orderBy = $request->orderBy;
        $limit = $request->limit;
        $page = $request->page;
        $relation = $request->relation;
        $value = $request->value;
        $asc = $request->asce  ? 'asc' : 'desc';

        $buildings = Building::join('addresses','addresses.id','=','buildings.address_id')
            ->join('cities','cities.id','=','addresses.city_id')
            ->where($relation,'ilike','%'.$value.'%')
            ->whereHasAccess()
            ->orderBy($orderBy,$asc)
            ->select(['buildings.*','cities.name as city','addresses.street','addresses.neighborhood'])
            ->paginate($limit);

        return $buildings;
    }

    public function getBuilding($id){

        return Building::whereHasAccess()->whereId($id)->with('address.city','entries')->first();
    }

    public function add(addBuildingRequest $request){

        $building = new Building();

        $this->buildingService->add($request, $building);

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
