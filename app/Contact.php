<?php

namespace PyroMans;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $fillable = [
        'email',
        'phone',
        'phone2'
    ];
}
