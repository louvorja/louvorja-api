<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ftp extends Model
{
    protected $table = 'ftp';
    protected $primaryKey = 'id_ftp';
    protected $fillable = [
        'active',
        'data',
        'id_language',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
