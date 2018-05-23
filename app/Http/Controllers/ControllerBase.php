<?php

namespace PyroMans\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PyroMans\Message;
use PyroMans\Setting;
use PyroMans\User;

class ControllerBase extends Controller
{
    public function __construct() {
	    $newMsg = Message::where('isNew', true)->orderBy('created_at', 'DESC')->take(8)->get();
	    $count = Message::where('isNew', true)->count();
	    $meta = Setting::first();
	    $user = User::first();
	    view()->share('newMsg', $newMsg);
	    view()->share('count', $count);
	    view()->share('meta', $meta);
	    view()->share('user', $user);
	    /*DB::listen(function ($query) {
		    dump($query->sql);
	    });*/
    }
}
