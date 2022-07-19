<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAlbum extends Model
{
    protected $table = 'categories_albums';
    protected $primaryKey = ['id_category', 'id_album'];
    public $incrementing = false;
    protected $fillable = [
        'id_category',
        'id_album',
        'name',
        'order',
        'id_language',
    ];

}
