<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
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
        return $this->base_url . $this->subdirectory . $this->file_name;
    }
}
