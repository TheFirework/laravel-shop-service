<?php

namespace App\Models;

class Product extends BaseModel
{
    protected $fillable = [
        'title', 'description', 'category_id', 'brand_id', 'images', 'on_sale', 'stock', 'is_free_shipping', 'collect_count', 'sku_id',
        'rating', 'sold_count', 'review_count', 'price', 'is_delete', 'unit', 'category_name', 'brand_name', 'market_price', 'cost_price',
        'goods_spec_format', 'goods_attr_format'
    ];

    protected $casts = [
        'on_sale' => 'boolean', // on_sale 是一个布尔类型的字段
    ];

    // 与商品SKU关联
    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
