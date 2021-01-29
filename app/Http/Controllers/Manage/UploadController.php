<?php

namespace App\Http\Controllers\Manage;

use App\Handlers\ImageUploadHandler;
use App\Handlers\FileUploadHandler;
use App\Models\AlbumPic;
use Illuminate\Http\Request;

class UploadController extends BaseController
{
    public function uploadImage(Request $request,ImageUploadHandler $uploader)
    {
        $folder = $request->input('folder','images');

        if($request->image){
            $result = $uploader->save($request->image, $folder);
            if ($result) {
                return $this->success_return($result);
            } else {
                return $this->fail_return('上传文件失败');
            }
        } else {
            return $this->fail_return('请选择上传文件');
        }
    }

    public function uploadFile(Request $request,FileUploadHandler $uploader)
    {
        $folder = $request->input('folder','images');

        if($request->file){
            $result = $uploader->save($request->file, $folder);
            if ($result) {
                return $this->success_return($result);
            } else {
                return $this->fail_return('上传文件失败');
            }
        } else {
            return $this->fail_return('请选择上传文件');
        }
    }

    /**
     * 上传图片到相册
     * @param Request $request
     * @param ImageUploadHandler $uploader
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadAlbum(Request $request,ImageUploadHandler $uploader)
    {
        $album_id = $request->input('album_id',1);
        if($request->image){
            $result = $uploader->save($request->image, 'album');
            if ($result) {
                $albumPic = AlbumPic::create([
                    'album_id' => $album_id,
                    'name' => $request->image->getClientOriginalName(),
                    'path' => $result['path']
                ]);
                $albumPic->album()->increment('number');
                return $this->success_return($albumPic);
            } else {
                return $this->fail_return('上传图片失败');
            }
        } else {
            return $this->fail_return('请选择上传图片');
        }
    }
}
