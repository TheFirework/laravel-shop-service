<?php

namespace App\Http\Requests\Manage\Category;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    public function rules()
    {
        $category = $this->route('category');
        return [
            'name' => 'required|unique:categories,name,'.$category->id
        ];
    }

    public function attributes()
    {
        return [
            'name' => '类目名称'
        ];
    }
}
