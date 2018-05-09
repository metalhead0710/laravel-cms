<?php

namespace PyroMans;

use Illuminate\Database\Eloquent\Model;

class PhotoCategory extends Model
{
    protected $table = 'photocats';
    protected $fillable = [
        'name',
        'slug',
        'folder',
        'picture',
        'thumb'
    ];

    public function photos()
    {
        return $this->hasMany('PyroMans\Photo', 'categoryId', 'id');
    }

}
