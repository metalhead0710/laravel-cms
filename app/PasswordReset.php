<?php

namespace PyroMans;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets';
    protected $fillable = [
        'email',
        'token',
    ];

    public function setUpdatedAt($value)
    {
        //Override standard Laravel update_at
    }

    public function getUpdatedAtColumn()
    {
        //Override standard Laravel update_at
    }
}
