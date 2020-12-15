<?php

namespace App\Http\Controllers\Manage;

use App\Handlers\ImageUploadHandler;
use Illuminate\Http\Request;

class UploadController extends BaseController
{
    public function upload(Request $request,ImageUploadHandler $uploader)
    {
        $folder = $request->input('folder','images');

        $file_prefix = $request->input('file_prefix','manage');

        if($request->avatar){
            $result = $uploader->save($request->avatar, $folder, $file_prefix);
            if ($result) {
                return $this->success_return($result);
            } else {
                return $this->fail_return('上传文件失败');
            }
        } else {
            return $this->fail_return('请选择上传文件');
        }
    }
}
