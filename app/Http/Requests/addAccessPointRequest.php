<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addAccessPointRequest extends FormRequest
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
            'elevator_id' => 'exists:elevators,id',
            'version_id' => 'exists:versions,id',
            'imei' => 'required|digits_between:3,20',
            'phone_number' => 'required',
        ];
    }
}
