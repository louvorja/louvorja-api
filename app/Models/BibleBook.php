<?php

namespace App\Models;

use App\Models\BaseModel;

class BibleBook extends BaseModel
{
    protected $table = 'bible_book';
    protected $primaryKey = 'id_bible_book';
    protected $fillable = [
        'book_number',
        'name',
        'testament',
        'keywords',
        'abbreviation',
        'id_language',
    ];
}
