<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumMusic extends Model
{
    protected $table = 'albums_musics';
    protected $primaryKey = ['id_album', 'id_music'];
    public $incrementing = false;
    protected $fillable = [
        'id_album',
        'id_music',
        'track',
        'id_language',
    ];

}
