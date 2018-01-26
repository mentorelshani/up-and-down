<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Models\City;
use App\Models\Building;

class CityController extends Controller
{
    public function getCities(){
    	return City::orderBy('name')->get(['id','name']);
    }

    public function getCompanies(){
        return  DB::table('buildings')->distinct()->select('company')->orderBy('company')->get();
    }

    public function getNeighborhoods(){
        return DB::table('addresses')->distinct()->select('neighborhood')->orderBy('neighborhood')->get();
    }

    public function getExistingAddresses(){

        $buildings = Building::select('id','name')->get();
        $companies = DB::table('buildings')->distinct()->select('company')->orderBy('company')->get();
        $cities = City::orderBy('name')->get(['id','name']);
        $neighborhoods = DB::table('addresses')->distinct()->select('neighborhood')->orderBy('neighborhood')->get();

        return array('buildings' => $buildings, 'companies' => $companies, 'cities' => $cities, 'neighborhoods' => $neighborhoods );
    }
}
