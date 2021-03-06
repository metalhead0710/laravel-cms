<?php

namespace Mik;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'sendname',
        'email',
        'content',
        'isNew'
    ];
}
