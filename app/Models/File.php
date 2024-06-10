<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $primaryKey = 'id_file';
    protected $fillable = [
        'id_file',
        'name',
        'type',
        'size',
        'base_dir',
        'base_url',
        'subdirectory',
        'file_name',
        'image_position',
        'version',
    ];
}
