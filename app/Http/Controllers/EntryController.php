<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Access_point;
use App\Models\Entry;
use App\Models\Elevator;

class EntryController extends Controller
{
	public function getEntry($id){
		return Entry::where('id',$id)->with('building.address.city','elevators','apartments.clients')->first();
	}

    public function getEntries(Request $request){

    	// return entries where Auth::user() has permission

        $orderBy = $request->orderBy;
        $limit = (int) $request->limit;
        $page = (int) $request->page;
        $relation = $request->relation;
        $value = $request->value;
        $asc = (bool)$request->asce  ? 'asc' : 'desc';

    	$skip = ($page - 1) * $limit;

    	$entries = Entry::join('buildings','buildings.id','=','entries.building_id')
    					->join('addresses','addresses.id','=','buildings.address_id')
                        ->join('cities','cities.id','=','addresses.city_id')
                        ->orderBy($orderBy,$asc);


    	if ($relation == "IMEI") {
    		$entries = $entries->whereIn('entries.id',
		    				Elevator::whereIn('elevators.id',
		    					Access_point::where('IMEI','ilike',"$value%")->select('elevator_id')->get()
		    				)->select('entry_id')->get()
	    				);
    	}
    	else {
    		$entries = $entries->where($relation,'ilike',"%$value%");
    	}

    	$count = $entries->get()->count();

    	$result = $entries->skip($skip)->take($limit)
    					  ->get(['entries.*','buildings.name as building','cities.name as city','addresses.street','addresses.neighborhood']);

    	return array('count' => $count, 'entries' => $result);				  


    }

    public function add(Request $request){

        $this->validate($request,[
            'building_id' => 'exists:buildings,id',
            'name' => 'required',
            'number_of_floors' => 'integer',
            'number_of_apartments' => 'integer'
        ]);

        $building_id = $request->building_id;
        $name = $request->name;
        $number_of_floors = $request->number_of_floors;
        $number_of_apartments = $request->number_of_apartments;

        $entry = new Entry();
        $entry->building_id = $building_id;
        $entry->name = $name;
        $entry->number_of_floors = $number_of_floors;
        $entry->number_of_apartments = $number_of_apartments;
        $entry->save();

        return $entry;
    }

    public function update(Request $request){

        $this->validate($request,[
            'building_id' => 'exists:buildings,id',
            'name' => 'required',
            'number_of_floors' => 'integer',
            'number_of_apartments' => 'integer'
        ]);

        $building_id = $request->building_id;
        $name = $request->name;
        $number_of_floors = $request->number_of_floors;
        $number_of_apartments = $request->number_of_apartments;

        $entry = new Entry();
        $entry->building_id = $building_id;
        $entry->name = $name;
        $entry->number_of_floors = $number_of_floors;
        $entry->number_of_apartments = $number_of_apartments;
        $entry->save();

        return $entry;

    }

    public function destroy($id){
        $a = Entry::find($id);

        if ($a != null) {
            $a->delete();
            return "u fshi";
        }
        return "Nuk ekziston";
    }




}
