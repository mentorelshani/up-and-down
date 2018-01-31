<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateRequest;
use App\Models\Apartment;
use App\Models\Card;
use App\Models\Client;
use Illuminate\Http\Request;
use DB;

class CardController extends Controller
{
    public function getCardsByEntry(PaginateRequest $request, $entry_id){

        $orderBy = $request->orderBy;
        $limit = $request->limit;
        $page = $request->page;
        $relation = $request->relation;
        $value = $request->value;
        $asc = $request->asce  ? 'asc' : 'desc';

        $apartment_ids = Apartment::where('entry_id', $entry_id)->get(['id']);
        $client_ids = Client::whereIn('apartment_id', $apartment_ids)->get(['id']);
        $cards = Card::whereIn('client_id', $client_ids);

        $cards = $cards->where(function($query) use ($relation,$value){
            foreach ($relation as $i){
                $query->orWhereRaw("cast($i as text) like '$value%'");
            }
        });

        $cards->orderBy($orderBy,$asc)
                ->with('client.apartment');

        return $cards->paginate($limit);
    }

    public function add(Request $request){

        $this->validate($request,[
            'client_id' => 'required|exists:clients,id',
            'site_code' => 'required|integer',
            'site_number' => 'required|integer',
            'active' => 'boolean'
        ]);

        $card = new Card();
        $card->client_id = $request->client_id;
        $card->site_code = $request->site_code;
        $card->site_number = $request->site_number;
        $card->active = $request->active;
        $card->save();

        return $card;
    }
}
