<?php

namespace PyroMans;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $fillable = [
        'title',
        'image',
        'text',
        'folder',
        'thumbUrl'
    ];

    public function url()
    {
        return $this->folder . '/' . $this->image;
    }
}
