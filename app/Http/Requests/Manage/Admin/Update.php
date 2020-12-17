<?php


namespace App\Http\Requests\Manage\Admin;


use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    public function rules()
    {
        $user = $this->route('admin');
        return [
            'name' => 'required',
            'username' => 'required|unique:admins,username,'.$user->id,
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
