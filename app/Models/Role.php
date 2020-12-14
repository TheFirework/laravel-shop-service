<?php

namespace App\Models;

class Role extends BaseModel
{
    protected $table = 'role';

    protected $fillable = ['role_name','remark','permissions'];
}
