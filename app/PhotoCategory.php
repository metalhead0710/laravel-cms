<?php

namespace Mik;

use Illuminate\Database\Eloquent\Model;

class PhotoCategory extends Model
{
    protected $table = 'photocats';
    protected $fillable = [
        'name',
        'slug',
        'picture',
        'folder'
    ];
    public function photoUrl()
    {
        return $this->folder . '/'. $this->picture;
    }
    public function thumbUrl()
    {
        return $this->folder . '/thumbs/'. $this->picture;
    }
    public function photos()
    {
        return $this->hasMany('Mik\Photo', 'categoryId', 'id');
    }

}
