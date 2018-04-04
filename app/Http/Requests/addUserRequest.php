<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addUserRequest extends FormRequest
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
            'username' => 'required|unique:users,username|alpha_dash',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'email' => 'required|email|unique:users,email',
            'birthday' => 'date_format:m-d-Y|before:today',
            'gender' => 'in:m,f',
            'role_id' => 'required|exists:roles,id'
        ];
    }
}
