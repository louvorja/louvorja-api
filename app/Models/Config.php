<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $primaryKey = 'id_category';
    protected $fillable = [
        'id_config',
        'key',
        'type',
        'value',
    ];
}
