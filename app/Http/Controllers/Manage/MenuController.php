<?php

namespace App\Http\Controllers\Manage;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends BaseController
{
    public function index(Request $request)
    {
        $menus = Menu::where('is_delete','=',0)->get();

        return $this->success_return($menus);
    }
}
