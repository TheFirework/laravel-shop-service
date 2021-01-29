<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Env;

class Brand extends Model
{
    protected $fillable = ['name','cover'];

    public function getCoverAttribute($value)
    {
        return Env::get('APP_URL').$value;
    }

    public function products()
    {
        return $this->hasMany(Product::class,'brand_id','id');
    }
}
