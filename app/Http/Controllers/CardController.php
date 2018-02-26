<?php

namespace App\Http\Controllers;

use App\Http\Requests\addCardRequest;
use App\Http\Requests\giveAccessToCardRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\updateCardAccessRequest;
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

//        return $card_accesses;

        $cards = Card::whereIn('cards.id', $card_accesses)->join('clients','clients.id','=','cards.client_id');

        $cards = $cards->where(function($query) use ($relation,$value){
            foreach ($relation as $i){
                $query->orWhereRaw("cast($i as text) ilike '$value%'");
            }
        });

        return $cards->orderBy($orderBy,$asc)->select(['cards.*','clients.firstname','clients.lastname'])->paginate($limit);
    }

    public function getCardAccess($card_id){

        $relay_ids = Card_access::where('card_id', $card_id)->select(['relay_id'])->get();
        $access_point_ids = Relay::whereIn('id', $relay_ids)->select(['access_point_id'])->get();
        $elevator_ids = Access_point::whereIn('id', $access_point_ids)->select(['elevator_id'])->get();
        $entry_ids = Elevator::whereIn('id', $elevator_ids)->select(['entry_id'])->get();
        $building_ids = Entry::whereIn('id', $entry_ids)->select(['building_id'])->get();

        $buildings = Building::whereIn('id', $building_ids)->with(['entries' => function ($query) use($entry_ids, $elevator_ids, $access_point_ids, $relay_ids){
            $query->whereIn('id', $entry_ids)->with(['elevators' => function ($query) use ($elevator_ids, $access_point_ids, $relay_ids){
                $query->whereIn('id', $elevator_ids)->with(['access_points' => function($query) use ($access_point_ids, $relay_ids){
                    $query->whereIn('id', $access_point_ids)->with(['relays' => function($query) use ($relay_ids){
                        $query->whereIn('id', $relay_ids);
                    }]);
                }]);
            }]);
        }])->get();

        return $buildings;
    }


    public function updateCardAccess(updateCardAccessRequest $request){

        $card_access = Card_access::where('card_id', $request->card_id)->select('relay_id')->get();

        $relays = Relay::whereIn('id', $card_access)->where('access_point_id', $request->access_point_id)->get();

        $current_relays = [];
        $new_relays = $request->relay_id;

        for ($i = 0; $i<count($relays); $i++) {
            $current_relays[$i] = $relays[$i]->id;
        }

        $insert = array_values(array_diff($new_relays,$current_relays));
        $delete = array_values(array_diff($current_relays,$new_relays));

        return array('delete'=> $delete , 'insert' => $insert);
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

    public function deleteAccess(giveAccessToCardRequest $request){

        foreach ($request->relay_id as $relay) {
            $card_access = Card_access::where('card_id', $request->card_id)->where('relay_id', $relay)->first();
            if($card_access != null)
                $card_access->delete();
        }
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
