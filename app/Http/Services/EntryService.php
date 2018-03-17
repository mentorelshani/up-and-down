<?php
/**
 * Created by PhpStorm.
 * User: Mentori
 * Date: 1/19/2018
 * Time: 1:09 PM
 */

namespace App\Http\Services;


class EntryService
{
    public function add($request, $entry){

        $entry->building_id = $request->building_id;
        $entry->name = $request->name;
        $entry->number_of_floors = $request->number_of_floors;
        $entry->number_of_apartments = $request->number_of_apartments;
        $entry->save();
    }

    public function update($request, $entry){

        $entry->building_id = $request->building_id;
        $entry->name = $request->name;
        $entry->number_of_floors = $request->number_of_floors;
        $entry->number_of_apartments = $request->number_of_apartments;
        $entry->update();
    }
}