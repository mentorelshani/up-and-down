<?php
/**
 * Created by PhpStorm.
 * User: Mentori
 * Date: 1/17/2018
 * Time: 4:26 PM
 */

namespace App\Http\Services;


use App\Models\Apartment;

class ClientService
{
    public function findApartment($entry_id, $door_number){

        $apartment = Apartment::where('entry_id',$entry_id)
            ->where('door_number', $door_number)
            ->first();

        if ($apartment == null){
            $apartment = new Apartment();
            $apartment->entry_id = $entry_id;
            $apartment->door_number = $door_number;
            $apartment->save();
        }

        return $apartment->id;
    }

    public function add($request, $client)
    {
        $client->apartment_id = $this->findApartment($request->entry_id, $request->door_number);
        $client->firstname = $request->firstname;
        $client->lastname = $request->lastname;
        $client->gender = $request->gender;
        $client->birthday = $request->birthday;
        $client->email = $request->email;
        $client->phone_number = $request->phone_number;
        $client->type = "Client";
        $client->save();
    }

    public function update($request, $client)
    {
        $client->apartment_id = $this->findApartment($request->entry_id, $request->door_number);
        $client->firstname = $request->firstname;
        $client->lastname = $request->lastname;
        $client->gender = $request->gender;
        $client->birthday = $request->birthday;
        $client->email = $request->email;
        $client->phone_number = $request->phone_number;
        $client->type = "Client";
        $client->update();
    }
}