<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAlbum extends Model
{
    protected $table = 'categories_albums';
    protected $primaryKey = 'id_category_album';
    public $incrementing = false;
    protected $fillable = [
        'id_category',
        'id_album',
        'name',
        'order',
        'id_language',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'id_album', 'id_album');
    }
}
