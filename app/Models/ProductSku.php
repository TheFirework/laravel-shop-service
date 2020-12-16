<?php

namespace App\Models;


class ProductSku extends BaseModel
{
    protected $fillable = ['title', 'description', 'price', 'stock','is_delete'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
