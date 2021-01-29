<?php

namespace App\Http\Controllers\Manage;

use App\Http\Requests\Manage\Brand\Store;
use App\Http\Requests\Manage\Brand\Update;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends BaseController
{
    public function page(Request $request)
    {

        $builder = Brand::query()->orderBy('created_at', 'desc');

        if($search = $request->input('search', '')){
            $like = '%'.$search.'%';

            $builder->where(function ($query) use ($like) {
                $query->where('name', 'like', $like);
            });
        }

        $brands = $builder->paginate($request->input('pageSize',15));

        return $this->success_return($brands);

    }

    public function store(Store $request)
    {
        $data = $request->all();

        $brand = Brand::create($data);

        return $this->success_return($brand);
    }

    public function update(Update $request,Brand $brand)
    {
        $data = $request->all();

        if(preg_match("/^http(s)?:\\/\\/.+/",$data['cover'])){
            unset($data['cover']);
        }

        if($brand->update($data)){
            return $this->success_return($brand,'更新成功');
        } else {
            return $this->fail_return('更新失败');
        }

    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return $this->success_return($brand);
    }
}
