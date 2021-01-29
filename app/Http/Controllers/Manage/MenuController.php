<?php

namespace App\Http\Controllers\Manage;

use App\Http\Requests\Manage\MenuRequest;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends BaseController
{
    public function index()
    {
        $menus = Menu::all()->toArray();
        $tree = $this->deepTree($menus);
        return $this->success_return(['menus'=>$menus,'tree'=>$tree]);
    }

    public function store(MenuRequest $request)
    {
        $menu = Menu::create($request->input());
        return $this->success_return($menu,'新增菜单成功');
    }

    public function update(Menu $menu,MenuRequest $request)
    {
        if($menu->update($request->input())){
            return $this->success_return([],'更新成功');
        } else {
            return $this->fail_return('更新失败');
        }
    }

    public function destroy(Request $request){
        $ids = $request->ids;

        if (!is_array($ids)) {
            $ids = [$ids];
        }

        Menu::whereIn('id',$ids)->delete();

        return $this->success_return([],'删除成功');
    }
}
