<?php

namespace App\Http\Controllers\Manage;

use App\Http\Requests\Manage\DeptRequest;
use App\Models\Dept;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeptController extends BaseController
{

    public function page()
    {
        $depts = Dept::with(['dept'])->where('is_delete',0)->orderBy('order_num','desc')->get();

        return $this->success_return($depts);
    }

    /**
     * 创建部门
     * @param DeptRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DeptRequest $request)
    {
        $data = $request->input();

        $dept = Dept::create($data);

        if($dept){
            return $this->success_return($dept,'创建成功');
        } else {
            return $this->fail_return('创建失败');
        }
    }

    /**
     * 更新单个部门
     * @param Request $request
     * @param Dept $dept
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Dept $dept,Request $request)
    {
        $dept->dept_name = $request->dept_name;
        $dept->order_num = $request->order_num;
        $dept->save();
        return $this->success_return($dept);
    }

    /**
     * 批量更新
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request)
    {
        $dept = new Dept();
        $res = $dept->updateBatch($request->ids);
        return $this->success_return($res);
    }

    /**
     * 删除部门
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        $ids = $request->ids;
        $deleteUser = $request->deleteUser;

        DB::beginTransaction();
        try {
            // 删除部门
            foreach ($ids as $id){
                $dept = Dept::find($id);

                $dept->is_delete = 1;
                if($deleteUser){
                    // 删除用户
                    $dept->user()->update(['is_delete'=>1]);
                } else {
                    // 将用户移动到顶级部门下
                    $dept->user()->update(['dept_id'=>1]);
                }
                $dept->save();
            }

            DB::commit();
            return $this->success_return([],'删除成功');
        }catch (\Exception $exception){
            DB::rollback();
            return $this->fail_return('删除失败');
        }
    }
}
