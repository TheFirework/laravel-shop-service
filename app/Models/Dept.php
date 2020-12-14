<?php

namespace App\Models;

class Dept extends BaseModel
{
    protected $table = 'dept';

    protected $fillable = ['dept_name','parent_id','is_delete','order_num'];

    public function dept()
    {
        return $this->hasOne(Dept::class,'id','parentId');
    }

    public function user()
    {
        return $this->hasMany(Admin::class,'dept_id','id');
    }
}
