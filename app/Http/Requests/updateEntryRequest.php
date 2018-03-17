<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateEntryRequest extends FormRequest
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
            'id' => 'exists:entries',
            'building_id' => 'exists:buildings,id',
            'name' => 'required',
            'number_of_floors' => 'integer',
            'number_of_apartments' => 'integer'
        ];
    }
}
