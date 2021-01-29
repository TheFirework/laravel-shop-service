<?php

namespace App\Models;


class ProductSku extends BaseModel
{
    protected $fillable = ['title', 'description', 'price', 'stock', 'is_delete', 'market_price', 'image', 'cost_price', 'discount_price', 'weight',
        'sold_count', 'collect_count', 'review_count', 'category_name', 'brand_name', 'unit', 'on_sale', 'is_free_shipping', 'goods_spec_format',
        'goods_attr_format'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
