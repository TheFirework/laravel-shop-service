<?php

namespace App\Models;

use Illuminate\Support\Env;

class AlbumPic extends BaseModel
{
    protected $fillable = [
        'name','path', 'spec','album_id'
    ];

    public function getPathAttribute($value)
    {
        return Env::get('APP_URL').$value;
    }

    public function getOriginalPathAttribute($value)
    {
        return $value;
    }

    public function album()
    {
        return $this->belongsTo(Album::class,'album_id','id');
    }
}
