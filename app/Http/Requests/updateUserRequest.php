<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateUserRequest extends FormRequest
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
            'id' => 'required|exists:users,id',
            'username' => 'required|unique:users,username|alpha_dash',
            'password' => 'required|min:6',
            'email' => 'required|email',
            'birthday' => 'date_format:m-d-Y|before:today',
            'gender' => 'in:m,f',
            'role_id' => 'required|exists:roles,id'
        ];
    }
}
