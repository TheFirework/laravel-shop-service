<?php

namespace App\Http\Controllers\Manage;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function page(Request $request)
    {
        $builder = Product::query()->with(['category', 'brand'])->where('on_sale', true)->where('is_delete', 0);

        if ($search = $request->input('search', '')) {
            $like = '%' . $search . '%';
            // 模糊搜索商品标题、商品详情、SKU 标题、SKU描述
            $builder->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereHas('skus', function ($query) use ($like) {
                        $query->where('title', 'like', $like)
                            ->orWhere('description', 'like', $like);
                    });
            });
        }

        $products = $builder->select('id', 'title', 'category_id', 'brand_id', 'image', 'on_sale', 'rating', 'sold_count', 'review_count', 'price', 'updated_at')
            ->paginate($request->input('pageSize', 10));

        return $this->success_return($products);
    }

    public function store()
    {

    }

    public function destroy()
    {

    }

    public function update()
    {

    }
}
