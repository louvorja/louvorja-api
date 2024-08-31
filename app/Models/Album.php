<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
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
