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

        $brand->name = $data['name'];
        $brand->cover = $data['cover'];
        $brand->save();

        return $this->success_return($brand);
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return $this->success_return($brand);
    }
}
