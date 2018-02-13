<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckInRequest;
use App\Models\Check_in;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function getCheckIns(CheckInRequest $request, $access_point_id){

        $from = $request->from;
        $to = $request->to;

        $orderBy = $request->orderBy;
        $limit = $request->limit;
        $page = $request->page;
        $relation = $request->relation;
        $value = $request->value;
        $asc = $request->asce  ? 'asc' : 'desc';

        $check_ins =  Check_in::join('relays','relays.id','=','check_ins.relay_id')
            ->join('cards','cards.id','=','check_ins.card_id')
            ->join('clients','clients.id','=','cards.client_id')
            ->orderBy($orderBy,$asc)
            ->where('access_point_id', $access_point_id)
            ->whereBetween('check_ins.created_at', array($from,$to));

        $check_ins = $check_ins->where(function($query) use ($relation,$value){
            foreach ($relation as $i){
                $query->orWhereRaw("cast($i as text) ilike '$value%'");
            }
        });

        return $check_ins->select('check_ins.*', 'relays.floor','cards.site_code','cards.site_number','clients.firstname','clients.lastname')
            ->paginate($limit);
    }
}
