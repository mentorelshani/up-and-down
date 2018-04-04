<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addRoleRequest extends FormRequest
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
            'name' => 'required|unique:roles,name',
            'role_modules' => 'required|array',
            'role_modules.*.read' => 'boolean',
            'role_modules.*.write' => 'boolean',
            'role_modules.*.delete' => 'boolean',
            'role_modules.*.module' => 'required',
            'role_buildings' => 'required|array',
            'role_buildings.*.building_id' => 'exists:buildings,id|distinct',
            'role_buildings.*.read' => 'boolean',
            'role_buildings.*.write' => 'boolean',
            'role_buildings.*.delete' => 'boolean'
        ];
    }
}
