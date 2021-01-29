<?php

namespace App\Http\Controllers\Manage;

use App\Models\Album;
use App\Models\AlbumPic;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumController extends BaseController
{
    /**
     * 获取相册分组
     */
    public function getAlbumList()
    {
        $album_list = Album::all();
        return $this->success_return($album_list);
    }

    /**
     * 添加分组
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAlbum(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        $album = Album::create($validatedData);

        return $this->success_return($album);
    }

    /**
     * 修改分组
     * @param Request $request
     * @param Album $album
     * @return \Illuminate\Http\JsonResponse
     */
    public function editAlbum(Request $request,Album $album)
    {
        $request->validate([
            'name' => 'required|max:255',
            'id' => 'required'
        ]);

        $album->name = $request->input('name');

        $album->save();

        return $this->success_return($album);
    }

    /**
     * 删除分组
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAlbum(Album $album)
    {
        if ($album->is_default === 1) {
            return $this->fail_return('当前删除相册中存在默认相册,默认相册不可删除!');
        }

        if (count($album->picture)) {
            return $this->fail_return('当前删除相册中存在图片,不可删除!');
        }

        $album->delete();

        return $this->success_return($album);
    }

    /**
     * 修改文件名
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function modifyPicName(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $albumpic = AlbumPic::find($id);
        $albumpic->name = $name;
        $albumpic->save();
        return $this->success_return($albumpic);
    }

    /**
     * 修改图片分组
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function modifyFileAlbum(Request $request)
    {
        $ids = $request->input('ids');
        $album_id = $request->input('album_id');
        $oldalbum_id = $request->input('oldalbum_id');
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        DB::beginTransaction();
        try {
            $data = [];
            foreach ($ids as $key => $id){
                $data[$key] = [
                    'id'=>$id,
                    'album_id'=>$album_id
                ];
            }

            $album_pic = new AlbumPic();
            $album_pic->updateBatch($data);
            Album::query()->where('id','=',$oldalbum_id)->decrement('number',count($ids));
            Album::query()->where('id','=',$album_id)->increment('number',count($ids));
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }
        return $this->success_return($album_pic);
    }

    /**
     * 删除图片
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFile(Request $request)
    {
        $ids = $request->input('ids');
        $album_id = $request->input('album_id');
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        DB::beginTransaction();
        try {
            AlbumPic::whereIn('id',$ids)->delete();
            Album::query()->where('id','=',$album_id)->decrement('number',count($ids));
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }

        return $this->success_return([],'删除成功');
    }

    /**
     * 图像列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function page(Request $request)
    {

        $builder = AlbumPic::query()->orderBy('updated_at', 'desc');

        if ($name = $request->input('name', '')) {
            $like = '%' . $name . '%';
            $builder->where('name', 'like', $like);
        }

        if ($album_id = $request->input('album_id', '')) {
            $builder->where('album_id', '=', $album_id);
        }

        $list = $builder->paginate($request->input('pageSize', 10));

        return $this->success_return($list);
    }
}
