<?php

namespace PyroMans;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';
    protected $fillable = [
        'photo',
        'thumb',
        'sortOrder',
        'categoryId',
    ];

    public function category()
    {
        return $this->belongsTo(
            \PyroMans\PhotoCategory::class,
            'categoryId',
            'id'
        );
    }
}
