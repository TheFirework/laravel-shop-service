<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;

class DeptRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent_id' => 'required',
            'dept_name' => 'required',
            'order_num' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'parent_id.required' => '上级部门',
            'dept_name.required' => '部门名称',
            'order_num.required' => '排序',
        ];
    }
}
