<?php

namespace PyroMans;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';
    protected $fillable = [
        'file',
        'thumb',
        'sort_order'
    ];
}
