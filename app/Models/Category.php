<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'id_category';
    protected $fillable = [
        'id_category', 'name', 'slug', 'order', 'id_language',
    ];

}
