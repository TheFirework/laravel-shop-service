<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    public function childMenu(){
        return $this->hasMany('App\Models\Menu','parent_id','id');
    }

    public function allChildrenMenus(){
        return $this->childMenu()->with('allChildrenMenus');
    }
}
