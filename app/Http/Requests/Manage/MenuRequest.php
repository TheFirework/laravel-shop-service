<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required',
            'name' => 'required',
            'parentId' => 'required',
            'orderNum' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'type.required' => '节点类型',
            'name.required' => '节点名称',
            'parentId.required' => '上级菜单',
            'orderNum.required' => '排序',
        ];
    }
}
