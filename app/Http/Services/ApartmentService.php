<?php

namespace App\Http\Services;

class ApartmentService
{


    public function add($request, $apartment)
    {
        $apartment->entry_id = $request->entry_id;
        $apartment->door_number = $request->door_number;
        $apartment->save();

    }

    public function update($request, $apartment)
    {
        $apartment->entry_id = $request->entry_id;
        $apartment->door_number = $request->door_number;
        $apartment->update();

    }

}