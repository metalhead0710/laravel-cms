<?php

namespace Mik;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $fillable = [
        'email',
        'phone',
        'phone2',
        'vk',
        'facebook',
        'youtube'
    ];
}
