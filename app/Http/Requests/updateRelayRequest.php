<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateRelayRequest extends FormRequest
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
            'id' => 'required|exists:relays',
            'floor' => 'required|max:30',
            'pulse_time' => 'required|numeric',
        ];
    }
}
