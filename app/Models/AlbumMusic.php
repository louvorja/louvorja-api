<?php

namespace App\Models;

use App\Models\BaseModel;

class AlbumMusic extends BaseModel
{
    protected $table = 'albums_musics';
    protected $primaryKey = 'id_album_music';
    public $incrementing = false;
    protected $fillable = [
        'id_album',
        'id_music',
        'track',
        'id_language',
    ];


    public function music()
    {
        return $this->belongsTo(Music::class, 'id_music', 'id_music');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'id_album', 'id_album');
    }
}
