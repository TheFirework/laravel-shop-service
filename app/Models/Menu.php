<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['type', 'name','icon','parent_id','is_show','order_num','path','keep_alive','perms','is_delete','view_path'];

    public function childMenu(){
        return $this->hasMany('App\Models\Menu','parentId','id');
    }

    public function allChildrenMenus(){
        return $this->childMenu()->with('allChildrenMenus');
    }
}
