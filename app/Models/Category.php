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

}
