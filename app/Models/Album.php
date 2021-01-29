<?php

namespace App\Models;

class Album extends BaseModel
{
    protected $fillable = [
        'name','is_default','number'
    ];

    public function picture (){
        return $this->hasMany(AlbumPic::class,'album_id','id');
    }
}
