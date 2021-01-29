<?php

namespace App\Http\Controllers\Manage;

use App\Http\Requests\Manage\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RoleController extends BaseController
{
    public function index(Request $request)
    {
        $roles = Role::paginate($request->input('pageSize',10));

        return $this->success_return($roles);
    }

    public function store(RoleRequest $request)
    {
        $params = $request->input();

        $role = Role::create($params);

        return $this->success_return($role,'新增角色成功');
    }

    public function update(RoleRequest $request,Role $role)
    {
        if($role->update($request->input())){
            return $this->success_return([],'更新成功');
        } else {
            return $this->fail_return('更新失败');
        }
    }

    public function destroy(Request $request)
    {
        $ids = $request->ids;

        if (!is_array($ids)) {
            $ids = [$ids];
        }

        Role::whereIn('id',$ids)->delete();

        return $this->success_return([],'删除成功');
    }

}
