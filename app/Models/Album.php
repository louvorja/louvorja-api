<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $primaryKey = 'id_album';
    protected $fillable = [
        'id_album',
        'name',
        'image',
        'id_language',
    ];

}
