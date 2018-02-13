<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckInRequest;
use App\Models\Monitor;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    public function getMonitors(CheckInRequest $request){

        $from = $request->from;
        $to = $request->to;
        $access_point_id = $request->access_point_id;

        $orderBy = $request->orderBy;
        $limit = $request->limit;
        $page = $request->page;
        $relation = $request->relation;
        $value = $request->value;
        $asc = $request->asce  ? 'asc' : 'desc';

        $monitors =  Monitor::join('cards','cards.id','=','monitors.card_id')
            ->orderBy($orderBy,$asc)
            ->where('access_point_id', $access_point_id)
            ->whereBetween('monitors.created_at', array($from,$to));

        $monitors = $monitors->where(function($query) use ($relation,$value){
            foreach ($relation as $i){
                $query->orWhereRaw("cast($i as text) ilike '$value%'");
            }
        });

        return $monitors->select('monitors.*', 'cards.site_code','cards.site_number')
            ->paginate($limit);
    }
}
