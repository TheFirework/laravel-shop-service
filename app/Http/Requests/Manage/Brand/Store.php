<?php

namespace App\Http\Requests\Manage\Brand;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:brands',
            'cover' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '品牌名称',
            'cover' => '品牌图标',
        ];
    }
}
