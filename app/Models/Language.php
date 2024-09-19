<?php

namespace App\Models;

use App\Models\BaseModel;

class Language extends BaseModel
{
    protected $primaryKey = 'id_language';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id_language',
        'language',
    ];

}
