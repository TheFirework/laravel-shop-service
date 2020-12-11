<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = ['type', 'name','icon','parentId','isShow','orderNum','path','keepAlive','perms','is_delete'];

    public function childMenu(){
        return $this->hasMany('App\Models\Menu','parentId','id');
    }

    public function allChildrenMenus(){
        return $this->childMenu()->with('allChildrenMenus');
    }
}
