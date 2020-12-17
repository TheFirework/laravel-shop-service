<?php

namespace App\Http\Requests\Manage\Brand;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    public function rules()
    {
        $brand = $this->route('brand');

        return [
            'name' => 'required|unique:brands,name,'.$brand->id,
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
