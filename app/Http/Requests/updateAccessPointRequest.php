<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateAccessPointRequest extends FormRequest
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
            'id' => 'exists:access_points',
            'elevator_id' => 'required|integer',
            'version_id' => 'required|integer',
            'imei' => 'required|integer',
            'phone_number' => 'required',
        ];
    }
}
