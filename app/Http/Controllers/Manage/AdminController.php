<?php

namespace App\Http\Controllers\Manage;

use App\Http\Requests\Manage\Admin\Store;
use App\Http\Requests\Manage\Admin\Update;
use App\Models\Admin;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends BaseController
{
    public function index(Request $request)
    {
        // 创建一个查询构造器
        $builder = Admin::query()->where('is_delete', 0)
            ->with(['role', 'dept'])
            ->orderBy('created_at', 'desc')
            ->select('id', 'avatar', 'name', 'nickname', 'username', 'dept_id', 'phone', 'role_id', 'status', 'created_at', 'remark','email');

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

    public function menu()
    {
        $user = auth('manage')->user();

        $menuKey = 'menu-'.$user['id'];
        $premsKey = 'perms-'.$user['id'];

        $menus = [];
        $perms = [];

        if(Cache::has($menuKey)){
            $menus = Cache::get($menuKey);
        }

        if(Cache::has($premsKey)){
            $perms = Cache::get($premsKey);
        }

        if($menus && $perms){
            return $this->success_return([
                'menus' => $menus,
                'perms' => $perms
            ]);
        }

        $permissions = DB::table('roles')->where('id', $user['role_id'])->value('permissions');

        $permissions = explode(',', $permissions);

        $menus = Menu::whereIn('id', $permissions)->where('type','!=',3)->get()->toArray();

        $perms = Menu::whereIn('id', $permissions)->where('type','=',3)->pluck('perms');

        Cache::put($menuKey,$menus);
        Cache::put($premsKey,$perms);

        return $this->success_return([
            'menus' => $menus,
            'perms' => $perms
        ]);
    }

    public function store(Store $request)
    {
        $data = $request->all();

        $data['password'] = Hash::make('123456');

        $user = Admin::create($data);

        return $this->success_return($user);
    }

    public function update(Update $request,Admin $admin)
    {
        $data = $request->all();

        if(preg_match("/^http(s)?:\\/\\/.+/",$data['avatar'])){
            unset($data['avatar']);
        }

        if($data['password']){
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if($admin->update($data)){
            return $this->success_return([],'更新成功');
        } else {
            return $this->fail_return('更新失败');
        }
    }

    public function move(Request $request)
    {
        $ids = $request->ids;
        $dept_id = $request->dept_id;

        if (!is_array($ids)) {
            $ids = [$ids];
        }

        if (!$dept_id){
            return $this->fail_return('请选择转移的部门');
        }

        $data = [];

        foreach ($ids as $key => $id){
            $data[$key] = [
              'id'=>$id,
              'dept_id'=>$dept_id
            ];
        }

        $admin = new Admin();
        $res = $admin->updateBatch($data);
        return $this->success_return($res);
    }

    public function destroy(Request $request)
    {
        $ids = $request->ids;

        if (!is_array($ids)) {
            $ids = [$ids];
        }

        Admin::whereIn('id',$ids)->update([
            'is_delete'=>1
        ]);

        return $this->success_return([],'删除成功');
    }
}
