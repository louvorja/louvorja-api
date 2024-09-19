<?php

namespace App\Models;

use App\Models\BaseModel;

class Album extends BaseModel
{
    protected $primaryKey = 'id_album';
    protected $fillable = [
        'name',
        'id_file_image',
        'id_language',
        'color',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_albums', 'id_album', 'id_category')->withPivot(['name', 'order']);
    }
}
