<?php

namespace Mik;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $fillable = [
      'name',
      'description',
      'pic',
      'html_id',
      'onMain'
    ];
}
