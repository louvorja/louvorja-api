<?php

namespace App\Models;

use App\Models\BaseModel;

class Config extends BaseModel
{
    protected $primaryKey = 'id_category';
    protected $fillable = [
        'id_config',
        'key',
        'type',
        'value',
        'details',
    ];

    protected $casts = [
        'details' => 'array',
    ];
}
