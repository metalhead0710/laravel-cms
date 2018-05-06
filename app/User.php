<?php

namespace PyroMans;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;
        
    protected $table = 'users';
    protected $fillable = [
    	'username', 
    	'email', 
    	'firstName',
    	'lastName',
    	'password'
    ];
    protected $hidden = [
    	'password', 
    	'remember_token'
    ];
    
    public function getName()
    {
		if ($this->first_name && $this->last_name)
		{
			return "{$this->first_name} {$this->last_name}";
		}
		if ($this->first_name)
		{
			return $this->first_name;
		}
		return null;
	}
	public function getNameOrUsername()
	{
		return $this->getName() ?: $this->username;
	}
	public function getFirstNameOrUsername()
	{
		return $this->first_name ?: $this->username;
	}
}