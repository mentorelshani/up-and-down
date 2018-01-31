<?php

namespace App\Http\Controllers;

use App\Http\Requests\addClientRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\updateClientRequest;
use App\Http\Services\ClientService;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Card;

class ClientController extends Controller
{
    private $clientService;

    public function __construct(ClientService $clientService){

        $this->clientService = $clientService;
    }

    public function getClient($id){

        return Client::whereId($id)->with('apartment')->first();
    }

    public function getClients(PaginateRequest $request){

        //returns clients where Auth::user() has access

        $orderBy = $request->orderBy;
        $limit = $request->limit;
        $page = $request->page;
        $relation = $request->relation;
        $value = $request->value;
        $asc = $request->asce  ? 'asc' : 'desc';


        $clients = Client::join('apartments','apartments.id','=','clients.apartment_id')
            ->join('entries','entries.id','=','apartments.entry_id')
            ->join('buildings','buildings.id','=','entries.building_id')
            ->orderBy($orderBy,$asc)
            ->select();

        if (strpos($relation, 'card') !== false){
            $client_ids = Card::where($relation,'ilike',"$value%")->select('client_id')->get();
            $clients = $clients->whereIn('id',$client_ids);
        }
        else {
            $clients = $clients->where($relation, 'ILIKE', "$value%");
        }

        return $clients->paginate($limit);
    }

    public function getClientsByEntryId1($entry_id){
        //returns clients where Auth::user() has access
        return Client::join('apartments','apartments.id','=','clients.apartment_id')
            ->where('entry_id','=', $entry_id)
            ->with('apartment')
            ->orderBy('firstname')
            ->get(['clients.*']);
    }

    public function getClientsByEntryId(PaginateRequest $request, $entry_id){

        $orderBy = $request->orderBy;
        $limit = $request->limit;
        $page = $request->page;
        $relation = $request->relation;
        $value = $request->value;
        $asc = $request->asce  ? 'asc' : 'desc';

        $clients = Client::join('apartments','apartments.id','=','clients.apartment_id')
                        ->where('entry_id','=', $entry_id)
                        ->with('apartment')
                        ->orderBy($orderBy, $asc)
                        ->select(['clients.*']);

        $clients = $clients->where(function ($query) use ($relation, $value){
            foreach ($relation as $i)
                $query->orWhere($i,'ilike',"$value%");
        });

        return $clients->paginate($limit);
    }

    public function add(addClientRequest $request){

        $client = new Client();

        $this->clientService->add($request, $client);

        return $client;
    }

    public function update(updateClientRequest $request){

        $client = Client::find($request->id);

        $this->clientService->add($request, $client);

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