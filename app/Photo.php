<?php

namespace Mik;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';
    protected $fillable = [
        'filename',
        'categoryId'
    ];
    public $thumbUrl;

    public function category()
    {
        return $this->belongsTo('Mik\PhotoCategory', 'categoryId', 'id');
    }

    public function thumbUrl()
    {
        return $this->category->folder . '/thumbs/' . $this->filename;
    }
}
