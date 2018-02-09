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

        $elevators = Elevator::where('entry_id',$entry_id)->get(['id']);
        $access_points = Access_point::whereIn('elevator_id',$elevators)->get(['id']);
        $relays = Relay::whereIn('access_point_id',$access_points)->get(['id']);
        $card_accesses = Card_access::whereIn('relay_id',$relays)->get(['card_id']);

        $cards = Card::whereIn('cards.id', $card_accesses)->join('clients','clients.id','=','cards.client_id');

        $cards = $cards->where(function($query) use ($relation,$value){
            foreach ($relation as $i){
                $query->orWhereRaw("cast($i as text) ilike '$value%'");
            }
        });

        return $cards->orderBy($orderBy,$asc)->select(['cards.*','clients.firstname','clients.lastname'])->paginate($limit);
    }

    public function getCardAccess($card_id){

        return Card_access::where('card_id',$card_id)->with('relay.access_point.elevator.entry.building.address.city')->get();
    }

    public function giveAccess(giveAccessToCardRequest $request){

        foreach ($request->relay_id as $relay){
            $card_access = new Card_access();
            $card_access->card_id = $request->card_id;
            $card_access->relay_id = $relay;
            $card_access->save();
        }
        return;
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