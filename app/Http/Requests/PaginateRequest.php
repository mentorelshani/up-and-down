<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class PaginateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        Validator::extend('validRelation', function($attribute, $value){
//            foreach ($value as $v){
//                $relations  = ['addresses.street','addresses.neighborhood','buildings.company','buildings.name','entries.name','clients.firstname','clients.lastname','clients.email','clients.phone_number','cards.site_code','cards.site_number','elevators.identifier','elevators.type','elevators.made_in','elevators.company','access_points.imei','access_points.phone_number','access_points.notes'];
//                foreach ($relations as $r)
//                    if($r == $v)
//                        return true;
//            }
//            return false;
//        });

        return [
            'orderBy' => 'required',
            'limit' => 'required|integer',
            'page' => 'required|integer',
            'relation' => 'required|array',
            'asce' => 'boolean',
        ];
    }
}
