<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    protected $primaryKey = 'id_lyric';
    protected $fillable = [
        'id_music',
        'lyric',
        'aux_lyric',
        'id_file_image',
        'time',
        'instrumental_time',
        'show_slide',
        'order',
        'id_language',
    ];
}
