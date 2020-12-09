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
            'parentId' => 'required',
            'deptname' => 'required',
            'orderNum' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'parentId.required' => '上级部门',
            'deptname.required' => '部门名称',
            'orderNum.required' => '排序',
        ];
    }
}
