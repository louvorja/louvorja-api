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
        'image',
        'folder',
        'file',
        'instrumental_file',
        'id_language',
    ];

}
