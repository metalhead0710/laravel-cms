<?php

namespace PyroMans;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $table = 'socials';
    protected $fillable = [
      'name',
      'icon',
      'thumb',
      'url'
    ];
}
