<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role_name' => 'required',
            'permissions' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'role_name.required' => '节点类型',
            'permissions.required' => '节点名称',
        ];
    }
}
