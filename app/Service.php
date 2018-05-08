<?php

namespace PyroMans;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $fillable = [
        'name',
        'pic',
        'thumb',
        'content',
        'customCss',
        'customJs',
    ];
}
