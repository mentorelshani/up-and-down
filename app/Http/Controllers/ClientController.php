<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Card;

class ClientController extends Controller
{
    public function getClient($id){
        return Client::where('id',$id)->with('apartment.entry.building.address.city')->get();
    }

    public function getClients(Request $request){

        //returns clients where Auth::user() has access

        $orderBy = $request->orderBy;
        $limit = $request->limit;
        $page = $request->page;
        $relation = $request->relation;
        $value = $request->value;
        $asc = (bool)$request->asce  ? 'asc' : 'desc';

        $skip = ($page - 1) * $limit;

        $clients = Client::join('apartments','apartments.id','=','clients.apartment_id')
                         ->join('entries','entries.id','=','apartments.entry_id')
                         ->join('buildings','buildings.id','=','entries.building_id')
                         ->orderBy($orderBy,$asc);

        if (strpos($relation, 'card') !== false){
            $client_ids = Card::where($relation,'ilike',"$value%")->select('client_id')->get();
            $clients = $clients->whereIn('id',$client_ids);
        }
        else {
            $clients = $clients->where($relation, 'ILIKE', "$value%");
        }

        $count = $clients->get()->count();

        $result = $clients->skip($skip)->take($limit)
                          ->get(['clients.*','apartments.door_number','entries.name as entry','buildings.name as building']);

        return array('count' => $count , 'result' => $result);
    }
    public function getClientsByEntryId($entry_id){
        //returns clients where Auth::user() has access
        return Client::join('apartments','apartments.id','=','clients.apartment_id')
                     ->where('entry_id','=', $entry_id)->with('apartment')->get(['clients.*']);
    }

    public function add(Request $request){

        $this->validate($request,[
            'apartment_id' => 'exists:apartments,id',
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'alpha|size:1',
            'birthday' => 'date',
            'email' => 'email',
            'phone_number' => 'required',
        ]);

        $apartment_id = $request->apartment_id;
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $gender = $request->gender;
        $birthday = $request->birthday;
        $email = $request->email;
        $phone_number = $request->phone_number;

        $client = new Client();
        $client->apartment_id = $apartment_id;
        $client->firstname = $firstname;
        $client->lastname = $lastname;
        $client->gender = strtoupper($gender);
        $client->birthday = $birthday;
        $client->email = $email;
        $client->phone_number = $phone_number;
        $client->type = "Client";
        $client->save();

        return $client;
    }

    public function update(Request $request){

        $this->validate($request,[
            'id' => 'exists:clients',
            'apartment_id' => 'exists:apartments,id',
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'alpha',
            'birthday' => 'date',
            'email' => 'email',
        ]);

        $id = $request->id;
        $apartment_id = $request->apartment_id;
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $gender = $request->gender;
        $birthday = $request->birthday;
        $email = $request->email;
        $phone_number = $request->phone_number;

        $client = Client::whereId($id)->first();
        $client->apartment_id = $apartment_id;
        $client->firstname = $firstname;
        $client->lastname = $lastname;
        $client->gender = strtoupper($gender);
        $client->birthday = $birthday;
        $client->email = $email;
        $client->phone_number = $phone_number;
        $client->update();

        return $client;
    }

    public function destroy($id){

        $a = Client::find($id);

        if ($a != null) {
            $a->delete();
            return "u fshi";
        }
        return "Nuk ekziston";
    }

}
