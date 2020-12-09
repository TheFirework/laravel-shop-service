<?php

namespace App\Models;

class Dept extends BaseModel
{
    protected $table = 'dept';

    protected $fillable = ['deptname','parentId','is_delete','orderNum'];

    public function dept()
    {
        return $this->hasOne(Dept::class,'id','parentId');
    }

    public function user()
    {
        return $this->hasMany(Admin::class,'dept_id','id');
    }
}
