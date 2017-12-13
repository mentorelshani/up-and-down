<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Building;
use App\Models\City;

class BuildingController extends Controller
{
	
    public function getBuildings (Request $request){

        // return Buildings where Auth::user() has permission

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

    public function getBuilding($id){
        return Building::whereHasAccess()->where('id',$id)->with('address.city','entries.elevators.access_points')->first();
    }

    public function getExistingAddresses(){
    	$companies = DB::table('buildings')->distinct()->select('company')->orderBy('company')->get();
    	$cities = City::orderBy('name')->get(['id','name']);
    	$neighborhoods = DB::table('addresses')->distinct()->select('neighborhood')->orderBy('neighborhood')->get();

    	return array('companies' => $companies, 'cities' => $cities, 'neighborhoods' => $neighborhoods );
    }

    public function addBuilding(Request $request){

        $this->validate($request,[
            'city_id' => 'required|integer',
            'name' => 'required',
            'company' => 'required',
            'street' => 'required',
            'location' => 'required',
            'neighborhood' => 'required',
        ]);


    	$city_id = $request->city_id;
		$name = $request->name;
		$company = $request->company;
		$street = $request->street;
		$location = $request->location;
		$neighborhood = $request->neighborhood;

		$address = Address::where('city_id',$city_id)
						  ->where('street', $street)
						  ->where('neighborhood', $neighborhood)
						  ->first();

		if ($address == null){
			$address = new Address();
			$address->city_id = $city_id;
			$address->neighborhood = ucwords(strtolower($neighborhood));
			$address->street = ucwords(strtolower($street));
			$address->save();
		}


		$building = new Building();
		$building->address_id = $address->id;
		$building->name = ucwords(strtolower($name));
		$building->company = ucwords(strtolower($company));
		$building->location = $location;
		$building->created_by = 1;
		$building->save();

        return $building;

    }

    public function updateBuilding(Request $request){


        $this->validate($request,[
            'city_id' => 'required|integer',
            'name' => 'required',
            'company' => 'required',
            'street' => 'required',
            'location' => 'required',
            'neighborhood' => 'required',
        ]);

        $city_id = $request->city_id;
        $name = $request->name;
        $company = $request->company;
        $street = $request->street;
        $location = $request->location;
        $neighborhood = $request->neighborhood;

        $address = Address::where('city_id',$city_id)
                          ->where('street','ilike', $street)
                          ->where('neighborhood','ilike', $neighborhood)
                          ->first();

        if ($address == null){
            $address = new Address();
            $address->city_id = $city_id;
            $address->neighborhood = ucwords(strtolower($neighborhood));
            $address->street = ucwords(strtolower($street));
            $address->save();
        }

        $id = $request->id;


        $building = Building::where('id',$id)->first();
        $building->address_id = $address->id;
        $building->name = ucwords(strtolower($name));
        $building->company = ucwords(strtolower($company));
        $building->location = $location;
        $building->created_by = 1;
        $building->update();

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
