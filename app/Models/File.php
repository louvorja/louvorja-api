<?php

namespace App\Models;

use App\Models\BaseModel;

class File extends BaseModel
{
    protected $primaryKey = 'id_file';
    protected $fillable = [
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

    protected $appends = [
        'url',
    ];

    public function getUrlAttribute()
    {
        return env("FILES_URL") . $this->dir . "/" . $this->file_name;
    }
}
