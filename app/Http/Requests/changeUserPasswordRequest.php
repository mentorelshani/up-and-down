<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class changeUserPasswordRequest extends FormRequest
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
        Validator::extend('checkPassword', function($attribute, $value,$parameters,$validator) {

            $user_id = array_get($validator->getData(), $parameters[0]);

            $user = User::find($user_id);

            return Hash::check($value, $user->password);
        });

        return [
            'password' => 'required|min:6|different:old_password',
            'confirm_password' => 'required|same:password',
            'user_id' => 'exists:users,id',
            'old_password' => 'required|checkPassword:user_id'
        ];
    }
}
