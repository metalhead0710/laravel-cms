<?php

namespace Mik;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'mainTitle',
        'subTitle',
        'meta_keywords',
        'meta_description'
    ];
    public $timestamps = false;
}
