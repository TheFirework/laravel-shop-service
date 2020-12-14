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
            'parent_id' => 'required',
            'order_num' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'type.required' => '节点类型',
            'name.required' => '节点名称',
            'parent_id.required' => '上级菜单',
            'order_num.required' => '排序',
        ];
    }
}
