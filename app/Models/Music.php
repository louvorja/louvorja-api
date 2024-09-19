<?php

namespace App\Models;

use App\Models\BaseModel;

class Music extends BaseModel
{
    protected $table = 'musics';
    protected $primaryKey = 'id_music';
    protected $fillable = [
        'name',
        'id_file_image',
        'id_file_music',
        'id_file_instrumental_music',
        'id_language',
    ];

    public function albums()
    {
        return $this->belongsToMany(Album::class, 'albums_musics', 'id_music', 'id_album')->withPivot('track');
    }
}
