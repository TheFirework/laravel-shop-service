<?php


namespace App\Http\Controllers\Manage;


use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:manage', ['except' => ['login']]);
    }

    protected function success_return ($data = [],$message = 'success', $code = 200){
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function fail_return ($message = 'fail',$data = '', $code = 400){
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function getTree($data,$pid=0)
    {
        $tree = [];
        foreach ($data as $key => $item){
            if ($item['parent_id'] == $pid){
                $tree[$item['id']] = $item;
                unset($data[$key]);
                $tree[$item['id']]['children'] = $this->getTree($data, $item['id']);
            }
        }
        return $tree?$tree:'';
    }
}
