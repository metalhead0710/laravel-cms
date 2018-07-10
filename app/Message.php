<?php

namespace PyroMans;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'sendname',
        'email',
        'content',
        'isNew',
    ];

    public function getEmailAttribute($value)
    {
        return "Від: {$value}";
    }
}
