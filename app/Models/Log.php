<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $primaryKey = 'id_log';
    protected $fillable = [
        'table',
        'action',
        'old_values',
        'new_values',
        'user_id',
        'user',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'user' => 'array',
    ];
}
