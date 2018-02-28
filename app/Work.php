<?php

namespace Mik;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $table = 'works';
    protected $fillable = [
        'title',
        'typeId',
        'songUrl',
        'author',
        'songname',
        'video',
        'text'
    ];
}
