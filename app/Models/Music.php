<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $table = 'musics';
    protected $primaryKey = 'id_music';
    protected $fillable = [
        'id_music',
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
