<?php

namespace App\Http\Controllers;

use App\Http\Requests\addCardRequest;
use App\Http\Requests\giveAccessToCardRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\updateCardRequest;
use App\Models\Access_point;
use App\Models\Apartment;
use App\Models\Building;
use App\Models\Card;
use App\Models\Card_access;
use App\Models\Client;
use App\Models\Elevator;
use App\Models\Entry;
use App\Models\Relay;
use Illuminate\Http\Request;

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

    public function getCardAccess($card_id){

        return Card_access::where('card_id',$card_id)->with('relay.access_point.elevator.entry.building.address.city')->get();
    }

    public function giveAccess(giveAccessToCardRequest $request){

        foreach ($request->relay_ids as $relay_id){
            $card_access = new Card_access();
            $card_access->card_id = $request->card_id;
            $card_access->relay_id = $relay_id;
            $card_access->save();
        }
        return $request->relay_ids;

    }

    public function deleteAccess($card_id, $relay_id){

        $card_access = Card_access::where('card_id', $card_id)->where('relay_id', $relay_id)->first();
        $card_access->delete();
    }

    public function deleteAllAccesses($card_id){

        $card_accesses = Card_access::where('card_id', $card_id)->get();
        foreach ($card_accesses as $ca)
            $ca->delete();
    }

    public function add(addCardRequest $request){

        $card = new Card();
        $card->client_id = $request->client_id;
        $card->site_code = $request->site_code;
        $card->site_number = $request->site_number;
        $card->active = $request->active;
        $card->save();

        return $card;
    }

    public function update(updateCardRequest $request){

        $card = Card::find($request->id);
        $card->client_id = $request->client_id;
        $card->site_code = $request->site_code;
        $card->site_number = $request->site_number;
        $card->active = $request->active;
        $card->save();

        return $card;
    }

    public function destroy($id){

        $card = Card::findOrFail($id);
        $card->delete();
    }
}
