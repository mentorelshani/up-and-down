<?php
/**
 * Created by PhpStorm.
 * User: Mentori
 * Date: 1/17/2018
 * Time: 5:02 PM
 */

namespace App\Http\Services;


class ElevatorService
{
    public function add($request, $elevator){

        $elevator->entry_id = $request->entry_id;
        $elevator->identifier = $request->identifier;
        $elevator->type = $request->type;
        $elevator->made_in  = $request->made_in;
        $elevator->company  = $request->company;
        $elevator->save();
    }

    public function update($request, $elevator){

        $elevator->entry_id = $request->entry_id;
        $elevator->identifier = $request->identifier;
        $elevator->type = $request->type;
        $elevator->made_in  = $request->made_in;
        $elevator->company  = $request->company;
        $elevator->update();
    }
}