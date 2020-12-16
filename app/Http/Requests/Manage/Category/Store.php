<?php

namespace App\Http\Requests\Manage\Category;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:categories'
        ];
    }

    public function attributes()
    {
        return [
          'name' => '类目名称'
        ];
    }
}
