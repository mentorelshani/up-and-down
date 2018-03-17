<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updatePaymentRequest extends FormRequest
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
            'id' => 'exists:payments',
            'product_id' => 'exists:products,id',
            'client_id' => 'exists:clients,id',
            'price' => 'required|numeric',
        ];
    }
}
