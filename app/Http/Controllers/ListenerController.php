<?php

namespace App\Http\Controllers;

use App\Models\Access_point;
use App\Models\Card;
use App\Models\Card_access;
use App\Models\Relay;
use Illuminate\Http\Request;

class ListenerController extends Controller
{
    public function getNrOfTotalPackets($imei){

        $access_point_ids = Access_point::where('imei',$imei)->select('id')->get();
        $relays_ids = Relay::whereIn('access_point_id',$access_point_ids)->select('id')->get();
        $card_ids = Card_access::whereIn('relay_id',$relays_ids)->select('card_id')->get();
        $cards_count = Card::whereIn('id',$card_ids)->get()->count();

        return  ceil($cards_count/46);
    }



//
//    public function asd(){
//        return ;
//    }

}
