<?php

namespace Mik;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'people';
    protected $fillable = [
        'photoUrl',
        'thumbUrl',
        'folder',
        'first_name',
        'last_name',
        'info',
        'position',
        'vk',
        'facebook',
        'skype',
        'twitter',
    ];
    public function name()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
