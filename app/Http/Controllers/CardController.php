<?php

namespace App\Http\Controllers;

use App\Http\Requests\addCardRequest;
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
use phpDocumentor\Reflection\Types\Integer;

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
