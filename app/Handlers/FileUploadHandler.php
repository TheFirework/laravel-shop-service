<?php

namespace App\Handlers;

use  Illuminate\Support\Str;

class FileUploadHandler
{
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg','pdf', 'txt', 'zip', 'rar', '7z', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'mp3', 'mp4','avi','mov','mkv'];

    public function save($file, $folder)
    {
        $folder_name = "uploads/files/$folder/" . date("Ym/d", time());

        $upload_path = public_path() . '/' . $folder_name;

        $extension = strtolower($file->getClientOriginalExtension());

        $filename = time() . '_' . Str::random(10) . '.' . $extension;

        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $file->move($upload_path, $filename);

        return [
            'url' => config('app.url') . "/$folder_name/$filename",
            'path' => "/$folder_name/$filename",
        ];
    }
}
