<?php

namespace App\Models;

use App\Models\BaseModel;

class Category extends BaseModel
{
    protected $primaryKey = 'id_category';
    protected $fillable = [
        'name',
        'slug',
        'order',
        'type',
        'id_language',
    ];

    public function albums()
    {
        return $this->belongsToMany(Album::class, 'categories_albums', 'id_category', 'id_album')->withPivot(['name', 'order']);
    }
}
