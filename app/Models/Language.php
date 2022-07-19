<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $primaryKey = 'id_language';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id_language',
        'language',
    ];

}
