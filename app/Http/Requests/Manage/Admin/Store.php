<?php


namespace App\Http\Requests\Manage\Admin;


use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'username' => 'required|unique:admin',
            'nickname' => 'required',
            'role_id' => 'required',
            'dept_id' => 'required',
            'email' => 'nullable|email:rfc',
            'remark' => 'nullable|max:255'
        ];
    }

    public function attributes()
    {
        return [
            'name' => '姓名',
            'username' => '用户名',
            'nickname' => '昵称',
            'remark' => '备注'
        ];
    }
}
