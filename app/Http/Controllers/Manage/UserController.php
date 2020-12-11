<?php

namespace App\Http\Controllers\Manage;

use App\Models\Admin;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController
{
    public function page(Request $request)
    {
        // 创建一个查询构造器
        $builder = Admin::query()->where('is_delete', 0)
            ->with(['role', 'dept'])
            ->orderBy('created_at', 'desc')
            ->select('id', 'avatar', 'name', 'nickname', 'username', 'dept_id', 'phone', 'role_id', 'status', 'created_at', 'remark');

        if ($search = $request->input('search', '')) {
            $like = '%'.$search.'%';
            // 模糊搜索
            $builder->where(function ($query) use ($like) {
                $query->where('name', 'like', $like)
                    ->orWhere('username', 'like', $like)
                    ->orWhere('nickname', 'like', $like)
                    ->orWhere('phone', 'like', $like)
                    ->orWhere('email', 'like', $like)
                    ->orWhere('username', 'like', $like)
                    ->orWhere('username', 'like', $like)
                    ->orWhereHas('dept', function ($query) use ($like) {
                        $query->where('deptName', 'like', $like);
                    })
                    ->orWhereHas('role', function ($query) use ($like) {
                        $query->where('rolename', 'like', $like);
                    });
            });
        }

        if($dept_id = $request->input('dept_id','')){
            $builder->where('dept_id','=',$dept_id);
        }

        $users = $builder->paginate($request->input('pageSize',10));

        return $this->success_return($users);
    }

    public function permmenu()
    {
        $user = auth('manage')->user();

        $permissions = DB::table('role')->where('id', $user['role_id'])->value('permissions');

        $permissions = explode(',', $permissions);

        $menus = Menu::whereIn('id', $permissions)->where('type','!=',3)->get()->toArray();

        $perms = Menu::whereIn('id', $permissions)->where('type','=',3)->select('perms')->get()->toArray();

        return $this->success_return([
            'menus' => $menus,
            'perms' => $perms
        ]);
    }
}
