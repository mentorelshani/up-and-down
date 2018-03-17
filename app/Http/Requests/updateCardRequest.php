<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateCardRequest extends FormRequest
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
            'id' => 'exists:cards',
            'client_id' => 'required|exists:clients,id',
            'site_code' => 'required|integer',
            'site_number' => 'required|integer',
            'active' => 'boolean'
        ];
    }
}
