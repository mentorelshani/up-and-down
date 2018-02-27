<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateCardAccessRequest extends FormRequest
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
            'card_id' => 'exists:cards,id',
            'access_point_id' => 'exists:access_points,id',
            'relay_id' => 'required|array',
            'relay_id.*' => 'distinct|exists:relays,id'
        ];
    }
}
