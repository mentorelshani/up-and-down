<?php

namespace App\Http\Controllers;

use App\Http\Requests\addEntryRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\updateEntryRequest;
use App\Http\Services\EntryService;
use Illuminate\Http\Request;
use DB;
use App\Models\Access_point;
use App\Models\Entry;
use App\Models\Elevator;

class EntryController extends Controller
{
    private $entryService;

    public function __construct(EntryService $entryService){

        $this->entryService = $entryService;
    }

	public function getEntry($id){
		return Entry::where('id',$id)->with('building.address.city','elevators.access_points','apartments.clients')->first();
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

    public function index(PaginateRequest $request){

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

            foreach ($relation as $i) {
                if ($i == "IMEI"){
                    $entries = $entries->orWhereIn('entries.id',
                        Elevator::whereIn('elevators.id',
                            Access_point::where('imei','ilike',"$value%")->select('elevator_id')->get()
                        )->select('entry_id')->get()
                    );
                }
                else {
                    $entries = $entries->orWhere($i,'ilike',"%$value%");
                }
            }

            $entries = $entries->select(['entries.*','buildings.name as building','cities.name as city','addresses.street','addresses.neighborhood'])
                               ->orderBy($orderBy,$asc);

            return $entries->paginate($limit);
    }

    public function getEntriesByBuilding($building_id){
        return Entry::where('building_id',$building_id)->get();
    }

    public function add(addEntryRequest $request){

        $entry = new Entry();

        $this->entryService->add($request, $entry);

        return $entry;
    }

    public function update(updateEntryRequest $request){

        $entry = Entry::find($request->id);

        $this->entryService->update($request, $entry);

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
