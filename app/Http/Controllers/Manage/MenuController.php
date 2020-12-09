<?php

namespace App\Http\Controllers\Manage;

use App\Models\Menu;

class MenuController extends BaseController
{
    public function index()
    {
        $menus = Menu::where('is_delete','=',0)->get();

        return $this->success_return($menus);
    }
}
