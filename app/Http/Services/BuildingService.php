<?php

namespace App\Http\Services;
use App\Models\Address;

class BuildingService
{

    public function findAddress($city_id, $street, $neighborhood){

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

        return $address->id;
    }

    public function add($request, $building)
    {
        $building->address_id = $this->findAddress($request->city_id, $request->street, $request->neighborhood);
        $building->name = $request->name;
        $building->company = $request->company;
        $building->location = $request->location;
        $building->created_by = 1; //Auth::user()->id;
        $building->save();
    }

    public function update($request, $building)
    {
        $building->address_id = $this->findAddress($request->city_id, $request->street, $request->neighborhood);
        $building->name = $request->name;
        $building->company = $request->company;
        $building->location = $request->location;
        $building->created_by = 1; //Auth::user()->id;
        $building->update();
    }

}