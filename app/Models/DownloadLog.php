<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadLog extends Model
{
    protected $primaryKey = 'id_downalod_log';
    protected $fillable = [
        'version',
        'id_language',
    ];
}
