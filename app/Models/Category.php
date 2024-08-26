<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
