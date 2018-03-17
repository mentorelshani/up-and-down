<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

class addRelayRequest extends FormRequest
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
        return [
            'access_point_id' => 'required|exists:access_points,id',
            'relay' => 'required|max:30|unique_with:relays,access_point_id',
            'floor' => 'required|max:30',
            'pulse_time' => 'required|numeric',
        ];
    }
}
