<?php


namespace App\Http\Controllers\Manage;


use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:manage', ['except' => ['login']]);
    }

    protected function success_return($data = [], $message = 'success', $code = 200)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function fail_return($message = 'fail', $data = '', $code = 400)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * @param $data
     * @param int $pid
     * @param int $level
     * @return array|string
     */
    public function deepTree($data, $pid = 0, $level = 0)
    {
        $tree = [];
        foreach ($data as $key => $value) {
            if ($value['parent_id'] == $pid) {
                $tree[] = $value;
                unset($data[$key]);
                $value['level'] = $level;
                $value['children'] = $this->deepTree($data, $value['id'], $level + 1);
            }
        }
        return $tree;
    }


}
