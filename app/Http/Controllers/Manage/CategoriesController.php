<?php

namespace App\Http\Controllers\Manage;

use App\Http\Requests\Manage\Category\Store;
use App\Http\Requests\Manage\Category\Update;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends BaseController
{
    public function page(Request $request)
    {
        $search = $request->input('search');
        $result = Category::query()
            ->where('name', 'like', '%'.$search.'%')
            ->paginate($request->input('pageSize',10));

        return $this->success_return($result);
    }

    public function all(Request $request)
    {
        $categorys = Category::all();

        return $this->success_return($categorys);
    }


    public function store(Store $request)
    {
        $data = $request->all();

        $category = Category::create($data);

        return $this->success_return($category);
    }

    public function update(Update $request, Category $category)
    {
        $data = $request->all();

        $result = $category->update($data);

        return $this->success_return($result);
    }

    public function destroy(Category $category)
    {
        $products = $category->products;

        if(!$products->isEmpty()){
            return $this->fail_return('该分类下有商品不能删除');
        }

        $children = $category->children;

        if(!$children->isEmpty()){
            return $this->fail_return('该分类下有子类不能删除');
        }

        $category->delete();

        return $this->success_return([],'删除成功');
    }
}
